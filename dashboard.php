<?php
  session_start();
  if(isset($_SESSION['user']) || isset($_SESSION['admin'])) {

    if(isset($_SESSION['city'])) {

      if(isset($_SESSION['center']) && $_SESSION['center'] != null && $_SESSION['center'] > 0 && $_SESSION['daate'] > 0) {

      include 'init.php';
      $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');

      $day = array(

        '0'  =>  'كل الورديات',
        '1'  =>  'صباحيه',
        '2'  =>  'مسائية',    

      );

      ?>

        <div class="container">
          <div class="alert alert-info"><ul><li><?php echo $rows['name']; ?></li><li><?php echo $_SESSION['daate']; ?></li><li><?php echo $day[$_SESSION['day']]; ?></li></ul></div>
          <div class="row">
            <div class="dashboard">
              <div class="col-md-3">
                <a href="summ.php?do=add">
                  <div class="process one">
                    <i class="fa fa-plus"></i>
                    <span>إدخال بيانات</span>
                  </div>
                </a>
              </div>

                <div class="col-md-3">
                  <a target="_blank" href="summ.php?do=mange">
                    <div class="process two">
                      <i class="fa fa-table"></i>
                      <span>معاينة التقرير</span>
                    </div>
                  </a>
                </div>

                <div class="col-md-3">
                  <a target="_blank" href="report/centerreport.php">
                    <div class="process three">
                      <i class="fa fa-table"></i>
                      <span>تقرير المركز</span>
                    </div>
                  </a>
                </div>

            </div>
          </div>
        </div>

      <?php

    include $tmp . 'footer.php';

     }
    }

} else {

  header('Location: index.php');
  exite();

}

?>
