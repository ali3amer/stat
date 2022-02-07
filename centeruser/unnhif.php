<?php
session_start();
if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

    include 'init.php';
    $daate = $_SESSION['month'];

    /// --------------------- TABLE 12 ---------------------------------------------------------//
    /******************
     ******************
     ******************
     ******************/
    /// --------------------- TABLE 13 ---------------------------------------------------------//


    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $summ = getAllFrom('ID', 'freq', 'WHERE tnum = 13' . ' AND center = ' . $_SESSION['center'] . ' AND nameid = 103 ', " AND daate = '$daate' ", 'ID', '');

        if ($summ == null) {

            $unnhif        =  filter_var($_POST['unnhif'], FILTER_SANITIZE_NUMBER_INT);

            insertFreq(13, 103, $unnhif, $daate);
             ?>

            <div class="container text-center alert alert-success">تم إرسال التقرير بنجاح</div>

            <?php
            header("refresh: 3; url = dashboard.php");


        } else {
            header('Location: dashboard.php');
        }
    } else {


    /// --------------------- TABLE 13 ---------------------------------------------------------//
    /******************
     ******************
     ******************
     ******************/
    /// --------------------- THE END  -------------------------------------------------------//

    ?>

    <div class="container">
        <div class="row">
            <form class="admin form-horizontal" action="unnhif.php" method="post">
                <div class="form-group form-group-md">
                    <label class="col-md-3 control-label">تردد غير المؤمن عليهم :</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="unnhif" autocomplete="off"  />
                    </div>
                </div>

                <div class="form-group form-group-md">
                    <div class="col-md-offset-3 col-md-6">
                        <input class="btn btn-primary btn-lg" type="submit" name="" value="حــفـــظ">
                    </div>
                </div>

            </form>
        </div>
    </div>


    <?php

    include $tmp . 'footer.php';
    }

} else {

    header('Location: index.php');
    exite();

}

?>