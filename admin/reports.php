<?php
  session_start();

  if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

      include 'init.php'; ?>

        <div class="container">
          <div class="row">
            <div class="dashboard">

              <div class="col-md-3">
                <a target="_blank" href="selectcityreport.php">
                  <div class="process one">
                    <i class="fa fa-calendar"></i>
                    <span>تقارير المراكز</span>
                  </div>
                </a>
              </div>

              <div class="col-md-3">
                <a target="_blank" href="selectcity.php">
                  <div class="process two">
                    <i class="fa fa-calendar"></i>
                    <span>تقرير محلية</span>
                  </div>
                </a>
              </div>


              <div class="col-md-3">
                <a target="_blank" href="statedate.php">
                  <div class="process three">
                    <i class="fa fa-file-text-o"></i>
                    <span>تقريرالولايه</span>
                  </div>
                </a>
              </div>


                <div class="col-md-3">
                    <a target="_blank" href="quarterform.php">
                        <div class="process four">
                            <i class="fa fa-battery-quarter"></i>
                            <span>الربع</span>
                        </div>
                    </a>
                </div>

              <div class="col-md-3">
                <a target="_blank" href="halfform.php">
                  <div class="process four">
                    <i class="fa fa-battery-half"></i>
                    <span>النصف</span>
                  </div>
                </a>
              </div>

              <div class="col-md-3">
                <a target="_blank" href="yearform.php">
                  <div class="process three">
                    <i class="fa fa-table"></i>
                    <span>التقرير السنوي</span>
                  </div>
                </a>
              </div>

              <div class="col-md-3">
                <a target="_blank" href="clearingForm.php">
                  <div class="process two">
                    <i class="fa fa-money"></i>
                    <span>المقاصه</span>
                  </div>
                </a>
              </div>


              <div class="col-md-3">
                <a target="_blank" href="profsForm.php">
                  <div class="process one">
                    <i class="fa fa-stethoscope"></i>
                    <span>الأخصائيين</span>
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
