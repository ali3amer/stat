<?php
session_start();
if(isset($_SESSION['admin']) || isset($_SESSION['user'])) {


        if(isset($_SESSION['daate'])) {

            include 'init.php';

            ?>

            <div class="container">
                <div class="alert alert-info"><ul><li><?php echo $_SESSION['daate']; ?></li></ul></div>
                <div class="row">
                    <div class="dashboard">
                        <div class="col-md-3">
                            <a href="pharmacysum.php?do=add">
                                <div class="process one">
                                    <i class="fa fa-plus"></i>
                                    <span>إدخال بيانات</span>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a target="_blank" href="pharmacysum.php?do=mange">
                                <div class="process two">
                                    <i class="fa fa-table"></i>
                                    <span>معاينة تقرير الصيدليات</span>
                                </div>
                            </a>
                        </div>

                    </div>
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
