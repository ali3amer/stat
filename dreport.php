<?php
session_start();

if(isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    include 'init.php'; ?>

    <div class="container">
        <div class="row">
            <div class="dashboard">

                <div class="col-md-3">
                    <a target="_blank" href="citydate.php">
                        <div class="process one">
                            <i class="fa fa-calendar"></i>
                            <span>تقرير المحلية</span>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a target="_blank" href="quarterform.php">
                        <div class="process two">
                            <i class="fa fa-battery-quarter"></i>
                            <span>الربع</span>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a target="_blank" href="halfform.php">
                        <div class="process three">
                            <i class="fa fa-battery-half"></i>
                            <span>النصف</span>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a target="_blank" href="yearform.php">
                        <div class="process four">
                            <i class="fa fa-battery-full"></i>
                            <span>التقرير السنوي</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <?php

    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
