<?php
  session_start();

  
  if(isset($_SESSION['admin']) || isset($_SESSION['superman']) || isset($_SESSION['mreports'])) {

      include 'init.php'; ?>

        <div class="container">
          <div class="row">
            <div class="dashboard">

              <?php if(isset($_SESSION['admin'])){ ?>
              <div class="col-md-3">
                <a href="addrcity.php">
                  <div class="process one">
                    <i class="fa fa-plus"></i>
                    <span>إدخال بيانات</span>
                  </div>
                </a>
              </div>


                    <div class="col-md-3">
                        <a href="pharmacydate.php">
                            <div class="process two">
                                <i class="fa fa-ambulance"></i>
                                <span>إدخال بيانات الصيدليات</span>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3">
                        <a href="censusForm.php">
                            <div class="process three">
                                <i class="fa fa-line-chart"></i>
                                <span>التعداد السكاني</span>
                            </div>
                        </a>
                    </div>



              <div class="col-md-3">
                <a href="reports.php">
                  <div class="process four">
                    <i class="fa fa-wpforms"></i>
                    <span>التقارير</span>
                  </div>
                </a>
              </div>

            <div class="col-md-3">
              <a href="setting.php">
                <div class="process two">
                  <i class="fa fa-cog"></i>
                  <span>الإعدادات</span>
                </div>
              </a>
            </div>

              <div class="col-md-3">
                <a target="_blank" href="fullbackup.php">
                  <div class="process four">
                    <i class="fa fa-cloud-download"></i>
                    <span>نسخ إحتياطي</span>
                  </div>
                </a>
              </div>


              <div class="col-md-3">
                <a target="_blank" href="restore.php">
                  <div class="process one">
                    <i class="fa fa-cloud-download"></i>
                    <span> إستيراد تقرير </span>
                  </div>
                </a>
              </div>
            <?php }elseif(isset($_SESSION['mreports'])){ ?>

              <div class="col-md-3">
                <a href="reports.php">
                  <div class="process four">
                    <i class="fa fa-wpforms"></i>
                    <span>التقارير على مستوى الولايه</span>
                  </div>
                </a>
              </div>


              <div class="col-md-3">
                <a href="addrcity.php">
                  <div class="process one">
                    <i class="fa fa-wpforms"></i>
                    <span>التقارير على مستوى المحليه</span>
                  </div>
                </a>
              </div>



          <?php  } ?>
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
