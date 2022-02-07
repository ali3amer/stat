<?php
session_start();
if(isset($_SESSION['centeruser']) && isset($_SESSION['center']) && isset($_SESSION['center'])) {
    $nonavbar = '';
    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['datedetails'])) {

        $details = $_POST['datedetails'];

    } else {
        header('Location: dayvisit.php');
    }

    $visits = getAllFrom('ID, client', 'visit', 'WHERE center = ' . $_SESSION['center'],  " AND daate = '$details' ", 'ID', '');


    if($visits != null) {

        $gender    = array('1' => 'ذكر', '2' => 'انثى');

        $adjective = array('1' => 'مؤمن','2' => 'معال');

        ?>

        <div class="container-fluid" style="margin-top: 50px">
            <div><u><?php echo $details; ?></u></div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>الرقم</th>
                        <th>الأسم</th>
                        <th>الجنس</th>
                        <th>رقم التأمين</th>
                        <th>المخدم</th>
                        <th>الصفه</th>
                        <th>القطاع</th>
                        <th>العمر</th>
                        <th>المقابلات</th>
                        <th>الإختصاصي</th>
                        <th>التنويم والعمليات</th>
                        <th>الفحوصات</th>
                        <th>الأمراض المزمنه</th>
                        <th>التشخيص النهائي</th>
                        <th>الدواء</th>
                        <th>إجمالي التكلفة</th>
                    </tr>

        <?php
        $i = 1;
        foreach ($visits as $visit) {

            $meet = 0; $check = 0; $ill = 0; $medcin = 0; $prof = 0; $procces = 0; $total = 0;

            $client = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], "", 'ID', '');

            $sector = getOne('name', 'tables', 'WHERE ID = ' . $client['sector'], '', 'ID', '');
            $age = getOne('name', 'tables', 'WHERE ID = ' . $client['age'], '', 'ID', '');
            $defrent = getOne('defrent.defrent, tables.name as defrentn', 'defrent', 'INNER JOIN tables ON tables.ID = defrent.defrent WHERE defrent.visit = ' . $visit['ID'], '', 'defrent.ID', '');
            $meets = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $ills = getAllFrom('DISTINCT(ills.ill), tables.name as name', 'ills', ' INNER JOIN tables ON tables.ID = ills.ill WHERE visit = ' . $visit['ID'], '', 'ills.ID', '');
            $medcins = getOne('sum(cost) as cost', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $profs = getOne('sum(cost) as cost', 'prof', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $proccess = getOne('sum(cost) as cost', 'proccess', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');

            $meet += $meets['cost']; $check += $checks['cost']; $medcin += $medcins['cost']; $prof += $profs['cost'];
            $procces += $proccess['cost'];
            $total = $meet + $check + + $procces + $medcin + $prof;
            ?>


            <tr>
                <td><?php echo $i; $i++; ?></td>
                <td><?php echo $client['name']; ?></td>
                <td><?php echo $gender[$client['gender']]; ?></td>
                <td><?php echo $client['nhifid']; ?></td>
                <td><?php echo $client['server']; ?></td>
                <td><?php echo $adjective[$client['adjective']]; ?></td>
                <td><?php echo $sector['name'];?></td>
                <td><?php echo $age['name'];?></td>
                <td><?php echo $meet; ?></td>
                <td><?php echo $prof; ?></td>
                <td><?php echo $procces; ?></td>
                <td><?php echo $check; ?></td>
                <td>
                <?php
                
                foreach($ills as $ill) {
                    echo $ill['name'] . '. ';
                }
                   
                ?>
                </td>
                <td><?php echo $defrent['defrentn']; ?></td>
                <td><?php echo $medcin; ?></td>
                <td><?php echo $total; ?></td>
            </tr>


         <?php

        } ?>

                </table>
            </div>
        </div>


        <?php
    }
    ?>





    <?php

    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
