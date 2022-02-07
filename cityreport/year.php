<?php
session_start();
if(isset($_SESSION['admin']) || isset($_SESSION['user']) || isset($_SESSION['mreports'])) {

    $nonavbar = '';

    if(isset($_SESSION['city'])) {



        include 'init.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if($_POST['daate'] != 0) {
                $date = $_POST['daate'];

                $querydate = $query = " AND daate LIKE '%$date' AND city = " . $_SESSION['city'];

                $query2 = $query = " AND daate LIKE '%$date' ";

                $dates = checkrow('DISTINCT(daate) as daate', 'summ', 'WHERE city = ' . $_SESSION['city'], $query2, 'ID', '');

            } else {
                header('Location: ../admin/yearform.php');
            }



            if($dates > 11) {
                ?>
                <div class="report">
                    بسم الله الرحمن الرحيم <br />
                    الصندوق القومي للتأمين الصحي <br />
                    إدارة التخطيط <br />
                    قسم الإحصاء <br />
                    <?php echo 'التقرير السنوي للعام ' . $date; ?>
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

        header('Location: logout.php');

        exite();

    }

} else {

    header('Location: ../index.php');

    exite();

}

?>
