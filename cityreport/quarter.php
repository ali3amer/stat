<?php
session_start();
if(isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    $nonavbar = '';

    if(isset($_SESSION['city'])) {



        include 'init.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if($_POST['daate'] != 0) {
                $date = $_POST['daate'];
                $quarter = $_POST['quarter'];

                if($quarter == 1) {
                    $querydate = " AND daate IN ('01-$date' ,'02-$date', '03-$date') AND city = " . $_SESSION['city'];


                    $query2 = " AND daate IN ('01-$date' ,'02-$date', '03-$date') ";
                } elseif ($quarter == 2) {
                    $querydate = " AND daate IN ('04-$date' ,'05-$date' ,'06-$date') AND city = " . $_SESSION['city'];

                    $query2 = " AND daate IN ('04-$date' ,'05-$date' ,'06-$date') ";
                } elseif ($quarter == 3) {
                    $querydate = " AND daate IN ('07-$date', '08-$date', '09-$date') AND city = " . $_SESSION['city'];

                    $query2 = " AND daate IN ('07-$date', '08-$date', '09-$date') ";
                } elseif ($quarter == 4) {
                    $querydate = " AND daate IN ('10-$date', '11-$date', '12-$date') AND city = " . $_SESSION['city'];

                    $query2 = " AND daate IN ('10-$date', '11-$date', '12-$date') ";

                }

                $dates = checkrow('DISTINCT(daate) as daate', 'summ', 'WHERE city = ' . $_SESSION['city'], $query2, 'ID', '');

            } else {
                header('Location: ../admin/quarter1form.php');
            }



            $quarterName = array(

                    '1' => 'الربع الأول',
                    '2'  =>  'الربع الثاني',
                    '3'  =>  'الربع الثالث',
                    '4'  =>  'الربع الرابع'
            );


            if($dates > 2) {
                ?>
                <div class="report">
                    بسم الله الرحمن الرحيم <br />
                    الصندوق القومي للتأمين الصحي <br />
                    إدارة التخطيط <br />
                    قسم الإحصاء <br />
                    <?php echo ' تقرير' . $quarterName[$quarter] . ' للعام : ' . $date; ?>
                </div>


                <div class="container reports">

                    <?php


                    $query = "center.city = " . $_SESSION['city'];

                    duhReport($query, $query2, $querydate);

                    centerDetails($query, $query2);

                    allCenters($query, $query2);


                    reportShow($querydate); ?>

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

        header('Location: ../index.php');

        exite();

    }

} else {

    header('Location: ../index.php');

    exite();

}

?>
