<?php
session_start();
if(isset($_SESSION['centeruser']) && isset($_SESSION['center']) && isset($_SESSION['center'])) {
    $nonavbar = '';
    include 'init.php';

    $month = $_SESSION['month'];

    $medcinvisits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$month' ", 'ID', '');
    $med = 0;
    foreach($medcinvisits as $medcinvisit) {
        $medcincost = getOne('sum(cost) as cost', 'medcin', 'WHERE visit = ' . $medcinvisit['ID'], '', 'ID', '');
        $med += $medcincost['cost'];
    }

    $visits = getAllFrom('ID, client, daate', 'visit', 'WHERE center = ' . $_SESSION['center'],  " AND vmonth = '$month' ", 'ID', '');

    if($visits != null) {

        ?>

        <div class="container-fluid" style="margin-top: 50px">
            <div><u><?php echo $month; ?></u></div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>الرقم</th>
                        <th>التاريخ</th>
                        <th>الأسم</th>
                        <th>رقم التأمين</th>
                        <th>المخدم</th>
                        <th>الكشف الطبي</th>
                        <th>المعمل</th>
                        <th>أشعة</th>
                        <th>رسم قلب</th>
                        <th>موجات صوتية</th>
                        <th>التنويم والعمليات</th>
                        <?php if($med != 0) { ?>
                        <th>الدواء 75%</th>
                        <?php } ?>
                        <th>الجملة</th>
                    </tr>

        <?php
        $i = 1;
        
        foreach ($visits as $visit) {

            $client = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], "", 'ID', '');
            $meet = 0; $check = 0; $light = 0; $draw = 0; $freq = 0; $medcin = 0; $total = 0; $procces = 0;
            $meets = getOne('sum(cost) as cost', 'meet', ' WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $meet += $meets['cost'];

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

            $names = getAllFrom('ID', 'tables', "WHERE tnum = 10 AND name LIKE 'رسم%' ", '', 'ID', '');
            foreach($names as $name) {
                $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], ' AND checks = ' . $name['ID'], 'ID', '');
                $draw += $checks['cost'];
            }

            $names = getAllFrom('ID', 'tables', "WHERE tnum = 10 AND name LIKE 'موجات%' ", '', 'ID', '');
            foreach($names as $name) {
                $checks = getOne('sum(cost) as cost', 'checks', ' WHERE visit = ' . $visit['ID'], ' AND checks = ' . $name['ID'], 'ID', '');
                $freq += $checks['cost'];
            }
            
            $medcins = getOne('sum(cost) as cost', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
            $medcin += $medcins['cost'];
    
            $total = $meet + $check + $light + $draw + $freq + $procces + $medcin;
            
            ?>


            <tr>
                <td><?php echo $i; $i++; ?></td>
                <td><?php echo $visit['daate'] ?></td>
                <td><?php echo $client['name']; ?></td>
                <td><?php echo $client['nhifid']; ?></td>
                <td><?php echo $client['server'] ?></td>
                <td><?php echo $meet; ?></td>
                <td><?php echo $check; ?></td>
                <td><?php echo $light; ?></td>
                <td><?php echo $draw; ?></td>
                <td><?php echo $freq; ?></td>
                <td><?php echo $procces; ?></td>
                <?php if($med != 0) { ?>
                <td><?php echo $medcin; ?></td>
                <?php } ?>
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
