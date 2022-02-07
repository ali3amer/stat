<?php

session_start();

if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {
  include 'init.php';

  $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');
  ?>

<div class="container">
  <div class="alert alert-info"><ul><li><?php echo $rows['name']; ?></li><li><?php echo $_SESSION['month']; ?></li></ul></div>
  <div class="row">
    <div class="dashboard">
      <div class="col-md-3">
        <a href="visit.php">
          <div class="process one">
            <i class="fa fa-user-plus"></i>
            <span>زياره</span>
          </div>
        </a>
      </div>


    <div class="col-md-3">
        <a target="_blank" href="dayvisit.php" target="_blank">
            <div class="process two">
                <i class="fa fa-plus"></i>
                <span>السجل اليومي</span>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a target="_blank" href="monthdetails.php" target="_blank">
            <div class="process three">
                <i class="fa fa-plus"></i>
                <span>السجل الشهري</span>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a target="_blank" href="want.php" target="_blank">
            <div class="process four">
                <i class="fa fa-calendar"></i>
                <span>تقرير المطالبة الشهرية</span>
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
        <a class="reportok" href="reportpass.php">
          <div class="process two">
            <i class="fa fa-table"></i>
            <span>إعتماد التقرير الشهري</span>
          </div>
        </a>
      </div>

    <div class="col-md-3">
        <a target="_blank" href="showreport.php">
            <div class="process four">
                <i class="fa fa-bar-chart"></i>
                <span>عرض التقرير</span>
            </div>
        </a>
    </div>

    </div>
  </div>

</div>


<?php

  include $tmp . 'footer.php';
} else {
  header('Location: selectcenter.php');
}
?>
