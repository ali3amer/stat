<?php

session_start();

include 'init.php';

if(isset($_SESSION['user']) && isset($_SESSION['city'])){

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $date = $_POST['mdaate'] . '-' . $_POST['ydaate'];
/*
**
*****************************SUMM***********
**
*/

$summs = getAllFrom('*', 'summ', "WHERE daate = '$date' ", ' AND state = ' . $_SESSION['state'], 'ID', '');

if(!file_exists("D:backup/report_".$date.".php")){

$myfile = fopen("D:backup/report_".$date.".php", "x+") or die("Unable to open file!");

$txt = "<?php\n";

fwrite($myfile, $txt);

if($summs != null){


$txt = "$" . "summ = [\n";
fwrite($myfile, $txt);

foreach($summs as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq'] . ",\n" . "'cost'" . " => " . $summ['cost'] . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate']. "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}

/*
**
*****************************SUMMt***********
**
*/

$summst = getAllFrom('*', 'summt', "WHERE daate = '$date' ", ' AND state = ' . $_SESSION['state'], 'ID', '');

if($summst != null){

$txt = "$" . "summt = [\n";
fwrite($myfile, $txt);

foreach($summst as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq'] . ",\n" . "'cost'" . " => " . $summ['cost'] . ",\n" . "'servcost'" . " => " . $summ['servcost'] . ",\n" . "'jobcost'" . " => " . $summ['jobcost'] . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate'] . "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}

/*
**
*****************************FREQ***********
**
*/

$freqs = getAllFrom('*', 'freq', "WHERE daate = '$date' ", ' AND state = ' . $_SESSION['state'], 'ID', '');

if($freqs != null){

$txt = "$" . "freqs = [\n";
fwrite($myfile, $txt);

foreach($freqs as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq']  . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate'] . "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}


$txt = "?>\n";
fwrite($myfile, $txt);
fclose($myfile);

?>

<div class="container alert alert-success text-center">تم حفظ الملف بنجاح</div>

<?php

header("refresh: 3; url = userhome.php");
}else{

?>

<div class="container alert alert-danger text-center">هذا الملف موجود بالفعل</div>

<?php   
}

}else{ ?>

    <div class="container">
          <form class="form-horizontal" action="backup.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد التاريخ</label>
                <div class="col-md-3">
                  <select class="form-control" name="mdaate">
                    <option value="0">إختر ...</option>
                    <?php for($i = 1; $i <= 12;$i++):
                      if($i < 10) {
                        $date = '0' . $i;
                      } else {
                        $date = $i;
                      }
                    ?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="ydaate">
                    <option value="0">إختر ...</option>
                    <?php for($i = 2018; $i <= 2025;$i++):
                       $date = $i;?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

                  </select>
                </div>
              </div>
              <div class="form-group form-group-md">
                <div class="col-md-offset-3 col-md-6">
                  <input class="form-control btn-primary" type="submit" value="ادخال البيانات">
                </div>
              </div>
            </div>

          </form>
    </div>

<?php    
}
} else{ 
    header('Location: index.php');

}