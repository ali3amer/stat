<?php
  session_start();

  if(isset($_SESSION['admin']) || isset($_SESSION['superman'])) {

      include 'init.php'; ?>

        <div class="container">
          <div class="row">
            <div class="dashboard">

              <div class="col-md-3">
                <a href="member.php">
                  <div class="process four">
                    <i class="fa fa-users"></i>
                    <span>المستخدمين</span>
                  </div>
                </a>
              </div>

              <div class="col-md-3">
                <a href="centeruser.php">
                  <div class="process two">
                    <i class="fa fa-user-md"></i>
                    <span>ضباط التأمين</span>
                  </div>
                </a>
              </div>

              <?php if(isset($_SESSION['admin'])){ ?>
              <div class="col-md-3">
                <a href="tables.php">
                  <div class="process three">
                    <i class="fa fa-table"></i>
                    <span>إدارة الحقول</span>
                  </div>
                </a>
              </div>
              <?php } ?>

              <?php if(isset($_SESSION['superman'])) { ?>

              <div class="col-md-3">
                <a href="city.php">
                  <div class="process two">
                    <i class="fa fa-bank"></i>
                    <span>إدارة المحليات</span>
                  </div>
                </a>
              </div>

            <?php } ?>



            <?php if(isset($_SESSION['admin'])){ ?>
                <div class="col-md-3">
                    <a href="unit.php">
                        <div class="process one">
                            <i class="fa fa-home"></i>
                            <span>الوحدات الإدارية</span>
                        </div>
                    </a>
                </div>
            <?php } ?>

              <?php if(isset($_SESSION['admin'])){ ?>
              <div class="col-md-3">
                <a href="center.php">
                  <div class="process three">
                    <i class="fa fa-home"></i>
                    <span>إدارة المراكز</span>
                  </div>
                </a>
              </div>
              <?php } ?>

                <?php if(isset($_SESSION['admin'])){ ?>
                    <div class="col-md-3">
                        <a href="pharmacy.php">
                            <div class="process one">
                                <i class="fa fa-ambulance"></i>
                                <span>الصيدليات</span>
                            </div>
                        </a>
                    </div>
                <?php } ?>


              <div class="col-md-3">
                <a href="profs.php">
                  <div class="process two">
                    <i class="fa fa-user-md"></i>
                    <span>الاخصائيين</span>
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
