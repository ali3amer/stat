<?php
session_start();
if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $pass =  sha1($_POST['pass']);

        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
        $stmt->execute(array($_SESSION['username'], $pass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0) {
            header('Location: report.php');
        } else { ?>

            <div class="container text-center alert alert-danger">كلمة السر خاطئه</div>

        <?php

            header("refresh: 3; url = dashboard.php");

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
        <div class="alert alert-info">
            <ul>
                <li>أنت الأن على وشك إعتماد تقرير شهر <?php echo $_SESSION['month']; ?></li>
                <li>بعد إعتماد تقرير هذا الشهر لايمكن إضافة زيارات لهذا الشهر</li>
                <li>بعد إعتماد هذا التقرير لا يمكنك التراجع عن إعتماده</li>
                <li>لإعتماد التقرير الرجاء ادخال كلمة السر الخاصه بك</li>
            </ul>
        </div>
        <div class="row">
            <form class="admin form-horizontal" action="reportpass.php" method="post">
                <div class="form-group form-group-md">
                    <label class="col-md-3 control-label">كلمة السر :</label>
                    <div class="col-md-6">
                        <input class="form-control" type="password" name="pass" autocomplete=""  />
                    </div>
                </div>

                <div class="form-group form-group-md">
                    <div class="col-md-offset-3 col-md-6">
                        <input class="btn btn-primary" type="submit" name="" value="إعتماد">
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