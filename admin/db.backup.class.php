<?php
session_start();

header('content-type:text/html; charset=utf-8');
ob_start();

/*
 * DB.Backup Class
 *
 * @package		MYAZARC Classes
 * @category            Database Backup Class
 * @author		myazarc
 * @require		non
 * @createtime		13:40 18.07.2014 (H:i d.m.Y)[Europa/Istanbul]
 * @version		v0.1
 * @license     	http://myazarc.com/myazarc-classes-license/
 * @see			http://myazarc.com/db-backup-class/
 */

/*
 * Boolval php version => 5.5
 *   */
if (!function_exists('boolval')) {

    function boolval($in, $strict = false) {
        $out = null;
        $in = (is_string($in) ? strtolower($in) : $in);
        // if not strict, we only have to check if something is false
        if (in_array($in, array('false', 'no', 'n', '0', 'off', false, 0), true) || !$in) {
            $out = false;
        } else if ($strict) {
            // if strict, check the equivalent true values
            if (in_array($in, array('true', 'yes', 'y', '1', 'on', true, 1), true)) {
                $out = true;
            }
        } else {
            // not strict? let the regular php bool check figure it out (will
            //     largely default to true)
            $out = ($in ? true : false);
        }
        return $out;
    }

}

class dbBackup {

    private $host = 'localhost';
    private $user = 'root';
    private $name = 'stat';
    private $pass = '';
    private $port = 3306;
    private $tables;
    private $db;
    private $ds = "\n";

    public function __construct($host = NULL, $user = NULL, $name = NULL, $pass = NULL, $tables = array('*'), $port = 3306) {
        try {
            if ($host !== NULL) {
                $this->host = $host;
                $this->name = $name;
                $this->port = $port;
                $this->pass = $pass;
                $this->user = $user;
            }
            $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name . '; port=' . $port, $this->user, $this->pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->tables = $tables;
        } catch (Exception $exc) {
            $this->show_err('Connection Error', $exc->getMessage());
            exit();
        }

        $this->db->exec('SET NAMES "utf8"');
    }

    public function backup($backUpdir = 'D:/Backup/') {
        $sql=$this->_string().$this->_init();
        $zip = new ZipArchive();
        $date=date('d.m.Y-H.i.s');
        $filename = $backUpdir."backup-$this->name-$date.zip";

        if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
            exit("Could not open <$filename>\n");
        }
        $zip->addFromString("backup-$this->name-$date.sql", $sql);
        $zip->close();
    }

    private function _init() {
        $data = '';
        $ds = '<br>';
        echo '<pre>Mysql Connected. (Adapter: PDO)' . $ds;
        ob_flush();
        flush();
        echo 'Finding tables...' . $ds;
        ob_flush();
        flush();
        if (in_array('*', $this->tables)) {
            $tables = $this->_getTables();
        } else {
            $this->show_err('Table doesn\'t exists.', 'Table doesn\'t exists.');
        }
        echo 'Finded tables(' . count($tables) . ').' . $ds;
        ob_flush();
        flush();
        echo 'Initializing tables...' . $ds;
        ob_flush();
        flush();
        foreach ($tables as $c) {
            echo 'Initializing <strong>' . $c . '</strong> table fields...' . $ds;
            ob_flush();
            flush();
            $fields = $this->_getTableFields($c);
            echo 'Initializing <strong>' . $c . '</strong> table create sql...' . $ds;
            ob_flush();
            flush();
            $createtables = $this->_getCreateTables($c);
            echo 'Initializing <strong>' . $c . '</strong> table insert sql...' . $ds;
            ob_flush();
            flush();
            $insert = $this->_createInsertSql($c, $fields);
            echo 'Merging sqls...' . $ds;
            ob_flush();
            flush();
            $data.=$createtables[1] . $this->ds . $this->ds . $insert . $this->ds . $this->ds ;
            echo 'Initialized <strong>' . $c . '</strong> table sqls....' . $ds;
            echo '>>OK' . $ds;
            ob_flush();
            flush();
        }

        return $data;
    }

    private function _getTables($param = TRUE) {
        $tableList = array();
        if ($param === TRUE) {
            $result = $this->db->query("SHOW TABLES");
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $tableList[] = $row[0];
            }
        }

        return $tableList;
    }

    private function _getCreateTables($param) {
        $w = $param;
        $result = $this->db->query("SHOW CREATE TABLE $w");
        $row = $result->fetch(PDO::FETCH_NUM);

        return $row;
    }

    private function _getTableFields($tablename) {
        $column = array();
        $select = $this->db->query("SELECT * FROM $tablename LIMIT 1");
        $total_column = $select->columnCount();
        for ($counter = 0; $counter < $total_column; $counter ++) {
            $meta = $select->getColumnMeta($counter);
            $column[] = $meta['name'];
        }

        return $column;
    }

    private function _string() {
        $value='';
        $value .= '--' . $this->ds;
        $value .= '-- MySQL database dump' . $this->ds;
        $value .= '-- Created by myazarc db.backup class, Powered by myazarc. ' . $this->ds;
        $value .= '-- http://myazarc.com ' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- Host: ' . $this->host . $this->ds;
        $value .= '-- Created: ' . date('d.m.Y H:i:s') . '. ' . '(' . time() . ')' . $this->ds;
        $value .= '-- PHP: ' . phpversion() . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- Database: `' . $this->name . '`' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- -------------------------------------------------------';
        $value .= $this->ds . $this->ds;
        return $value;
    }

    private function _createInsertSql($tablename, $fields) {
        $sql = "select `" . rtrim(implode('`, `', $fields), ', `') . "` from $tablename";
        $data = $this->basicQuery($sql);
        $insert = '';
        $insert.="INSERT INTO `$tablename` (`" . rtrim(implode('`, `', $fields), ', `') . "`) VALUES" . $this->ds;

        foreach ($data as $q) {
            $insert.='(';

            foreach ($fields as $m) {
                $insert.="'" . $q->$m . "',";
            }
            $insert = rtrim($insert, ',');
            $insert.='),' . $this->ds;
        }

        $insert = rtrim(rtrim($insert, $this->ds), ',') . ';' . $this->ds;

        return $insert;
    }

    private function basicQuery($sql) {
        $result = array();
        $query = $this->db->query($sql);
        $this->queryStatus = boolval($query);
        if ($this->queryStatus) {
            if ($query->rowCount()) {
                foreach ($query as $w) {
                    $result[] = (object) $w;
                } // foreach query end;
            }
        } else {
            $this->show_err($sql, $this->db->errorInfo());
        } // if query end;

        return $result;
    }

    public function show_err($sql, $sqlerr) {
        echo '<br><br><br><hr>';
        echo '<div><strong>SQL:</strong> ' . $sql . '<br>';
        echo '<strong>SQL Error:</strong> ' . $sqlerr . '<div>';
        echo '<br><br><br><hr>';
    }

}

ob_end_flush();

$a = new dbBackup;
$a->backup();
