<?php
  session_start();
  if(isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    if(isset($_SESSION['city'])) {

      include 'init.php'; ?>



        <div class="container">
          <div class="row">
            <div class="dashboard">


      <?php

      if(isset($_SESSION['user']) || isset($_SESSION['admin'])){

      ?>

            
              <div class="col-md-3">
                <a href="center.php">
                  <div class="process one">
                    <i class="fa fa-plus"></i>
                    <span>إدخال بيانات</span>
                  </div>
                </a>
              </div>



                <div class="col-md-3">
                    <a target="_blank" href="dreport.php">
                        <div class="process three">
                            <i class="fa fa-wpforms"></i>
                            <span>التقارير</span>
                        </div>
                    </a>
                </div>

              <div class="col-md-3">
                <a target="_blank" href="backup.php">
                  <div class="process four">
                    <i class="fa fa-cloud-upload"></i>
                    <span> تصدير تقرير </span>
                  </div>
                </a>
              </div>

            </div>
          </div>
        </div>

      <?php

      }elseif(isset($_SESSION['mreports'])){ ?>


        <div class="col-md-3">
            <a target="_blank" href="dreport.php">
                <div class="process three">
                    <i class="fa fa-wpforms"></i>
                    <span>التقارير</span>
                </div>
            </a>
        </div>

      <?php  
      } ?>

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
