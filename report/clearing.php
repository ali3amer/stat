<?php
session_start();
if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {
    $nonavbar = '';
    include 'init.php';


    $month = $_SESSION['month'];
    $sessioncard = $_SESSION['cardstate'];

    $centers = getAllFrom('ID', 'center', '', "", 'ID', '');

    foreach($centers as $center):

    $medcinvisits = getAllFrom('ID', 'visit', 'WHERE center = ' . $center['ID'], " AND vmonth = '$month' ", 'ID', '');
    $med = 0;
    foreach($medcinvisits as $medcinvisit) {
        $medcincost = getOne('sum(cost) as cost', 'medcin', 'WHERE visit = ' . $medcinvisit['ID'], '', 'ID', '');
        $med += $medcincost['cost'];
    }

    $visits = getAllFrom('visit.ID, client, center, daate, center.name', 'visit', 'INNER JOIN center ON visit.center = center.ID WHERE visit.center = ' . $center['ID'],  " AND vmonth = '$month' ", 'visit.ID', '');


    $statename = $_SESSION['statename'];

    if($sessioncard == 'all'){
        $and = " AND name != '$statename'";
    } else{
        $and = " AND name = '$sessioncard'";
    }
        
    $states  = getAllFrom('ID, name', 'tables', "WHERE tnum = 11 ", $and, 'ID', '');
    $mystate = getOne('ID, name', 'tables', "WHERE tnum = 11 AND name = '$statename'", '', 'ID', '');

    $mystateid = $mystate['ID'];

    

    

    if($visits != null) {
        ?>

        <div class="container-fluid" style="margin-top: 50px">
            <div><?php echo $month ?></div>
            <div class="table-responsive table-section breakpage">
                <table class="table table-bordered reports ">
                    <tr>
                        <th>الرقم</th>
                        <th>التاريخ</th>
                        <th>الأسم</th> 
                        <th>رقم التأمين</th>
                        <th>المخدم</th>
                        <th>المرفق</th>
                        <th>م الطبي</th>
                        <th>الطبيب</th>
                        <th>الاخصائي</th>
                        <th>م طبي اسنان</th>
                        <th>الاسنان</th>
                        <th>العمليات</th>
                        <th>الفحوصات</th>
                        <th>موجات صوتية</th>
                        <th>أشعة</th>
                        <th>الدواء 75%</th>
                        <th>الجملة</th>
                    </tr>

        <?php
        $i = 1;

        $tmdoctor = 0; $tmeet = 0; $tprof = 0; $tmdoctort = 0; $tmeett = 0; $tcheck = 0; $tlight = 0; $tfreq = 0; $tmedcin = 0; $ttotal = 0; $tprocces = 0;


        foreach($states as $state):
        foreach ($visits as $visit) {

            $client = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], " AND cardstate != '$mystateid' AND cardstate = " . $state['ID'], 'ID', '');
            

            if($client['name'] != null) {


            $mdoctor = 0; $meet = 0; $prof = 0; $mdoctort = 0; $meett = 0; $check = 0; $light = 0; $freq = 0; $medcin = 0; $total = 0; $procces = 0;
            $names = getAllFrom('ID', 'tables', "WHERE tnum = 7 AND name = 'مساعد طبي عمومي' ", '', 'ID', '');
            foreach($names as $name) {
                $mdoctors = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], ' AND meet = ' . $name['ID'], 'ID', '');
                $mdoctor += $mdoctors['cost'];
            }


            $names = getAllFrom('ID', 'tables', "WHERE tnum = 7 AND name = 'الطبيب العمومي' ", '', 'ID', '');
            foreach($names as $name) {
                $meets = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], ' AND meet = ' . $name['ID'], 'ID', '');
                $meet += $meets['cost'];
            }



            $profs = getOne('sum(cost) as cost', 'prof', ' WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $prof += $profs['cost'];


            $names = getAllFrom('ID', 'tables', "WHERE tnum = 7 AND name = 'مساعد طبي اسنان' ", '', 'ID', '');
            foreach($names as $name) {
                $mdoctorts = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], ' AND meet = ' . $name['ID'], 'ID', '');
                $mdoctort += $mdoctorts['cost'];
            }


            $names = getAllFrom('ID', 'tables', "WHERE tnum = 7 AND name = 'طبيب الاسنان' ", '', 'ID', '');
            foreach($names as $name) {
                $meetts = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], ' AND meet = ' . $name['ID'], 'ID', '');
                $meett += $meetts['cost'];
            }


            $proccess = getOne('sum(cost) as cost', 'proccess', ' WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $procces += $proccess['cost'];

            $names = getAllFrom('ID', 'tables', "WHERE tnum = 10 AND name LIKE 'فحوصات%' ", '', 'ID', '');
            foreach($names as $name) {
                $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], ' AND checks = ' . $name['ID'], 'ID', '');
                $check += $checks['cost'];
            }

            $names = getAllFrom('ID', 'tables', "WHERE tnum = 10 AND name LIKE 'أشع%' ", '', 'ID', '');
            foreach($names as $name) {
                $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], ' AND checks = ' . $name['ID'], 'ID', '');
                $light += $checks['cost'];
            }

            $names = getAllFrom('ID', 'tables', "WHERE tnum = 10 AND name LIKE 'موجات%' ", '', 'ID', '');
            foreach($names as $name) {
                $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], ' AND checks = ' . $name['ID'], 'ID', '');
                $freq += $checks['cost'];
            }
            
            $medcins = getOne('sum(cost) as cost', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $medcin += $medcins['cost'];
    
            $total = $mdoctor + $meet + $prof + $mdoctort + $meett + $check + $light + $freq + $procces + $medcin;

            $tmdoctor += $mdoctor; $tmeet += $meet; $tprof += $prof; $tmdoctort += $mdoctort; $tmeett += $meett;
            $tcheck += $check; $tlight += $light; $tfreq += $freq; $tmedcin += $medcin; $ttotal += $total; $tprocces += $procces;

            
            ?>


            <tr>
                <td><?php echo $i; $i++; ?></td>
                <td><?php echo $visit['daate'] ?></td>
                <td><?php echo $client['name']; ?></td>
                <td><?php echo $client['nhifid']; ?></td>
                <td><?php echo $client['server'] ?></td>
                <td><?php echo $visit['name'] ?></td>
                <td><?php echo $mdoctor; ?></td>
                <td><?php echo $meet; ?></td>
                <td><?php echo $prof; ?></td>
                <td><?php echo $mdoctort; ?></td>
                <td><?php echo $meett; ?></td>
                <td><?php echo $procces; ?></td>
                <td><?php echo $check; ?></td>
                <td><?php echo $freq; ?></td>
                <td><?php echo $light; ?></td>
                <td><?php echo $medcin; ?></td>
                <td><?php echo $total; ?></td>
            </tr>


         <?php


        }

        } ?>

        



        <?php
        endforeach; ?>

    <tr>
        <th colspan='6'> الجمـــــــــله</th>
        <th><?php echo $tmdoctor; ?></th>
        <th><?php echo $tmeet; ?></th>
        <th><?php echo $tprof; ?></th>
        <th><?php echo $tmdoctort; ?></th>
        <th><?php echo $tmeett; ?></th>
        <th><?php echo $tprocces; ?></th>
        <th><?php echo $tcheck; ?></th>
        <th><?php echo $tfreq; ?></th>
        <th><?php echo $tlight; ?></th>
        <th><?php echo $tmedcin; ?></th>
        <th><?php echo $ttotal; ?></td>
    </tr>

                </table>
            </div>
        </div>


    <?php
    } 




endforeach;
    include $tmp . 'footer.php';



} else {

    header('Location: ../index.php');
    exite();

}

?>
