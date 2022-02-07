<?php
session_start();
if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    $nonavbar = '';

    if(isset($_SESSION['state'])) {



        include 'init.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if($_POST['daate'] != 0) {
                $date = $_POST['daate'];
                $half = $_POST['half'];

                if($half == 1) {
                    $querydate = " AND daate IN ('01-$date', '02-$date', '03-$date', '04-$date', '05-$date', '06-$date') AND state = " . $_SESSION['state'];


                    $query2 = " AND daate IN ('01-$date', '02-$date', '03-$date', '04-$date', '05-$date', '06-$date') ";

                } elseif ($half == 2) {
                    $querydate = " AND daate IN  ('07-$date' ,'08-$date', '09-$date', '10-$date', '11-$date' , '12-$date') AND state = " . $_SESSION['state'];

                    $query2 = " AND daate IN  ('07-$date' ,'08-$date', '09-$date', '10-$date', '11-$date' , '12-$date') ";
                }

                $dates = checkrow('DISTINCT(daate) as daate', 'summ', 'WHERE state = ' . $_SESSION['state'], $query2, 'ID', '');

            } else {
                header('Location: ../admin/halfform.php');
            }



            $hlafName = array(

                '1'     => 'النصف الأول',
                '2'     =>  'النصف الثاني',
            );


            if($dates > 5) {
                ?>
                <div class="report">
                    بسم الله الرحمن الرحيم <br />
                    الصندوق القومي للتأمين الصحي <br />
                    إدارة التخطيط <br />
                    قسم الإحصاء <br />
                    <?php echo ' تقرير' . $hlafName[$half] . ' للعام : ' . $date; ?>
                </div>


                <div class="container reports">

                    <?php

                    totalReport($date);

                    getCensus($date);

                    $query = "center.state = " . $_SESSION['state'];

                    duhReport($query, $query2, $querydate);

                    centerDetails($query, $query2);

                    allCenters($query, $query2);

                    pharmacyDetails($query2);

                    reportShow($querydate);

                    pharmacyTotal($query2);

                    ?>

                </div>
                <?php
            } else { ?>

                <div style="margin-top: 50px" class="container alert alert-danger">
                    <ul>
                        <li>عفواً هذا التقرير لم يتم إعداده بعد</li>
                    </ul>
                </div>

                <?php
            }

            include $tmp . 'footer.php';
        }
    } else {

        header('Location: logout.php');

        exite();

    }

} else {

    header('Location: ../index.php');

    exite();

}

?>
