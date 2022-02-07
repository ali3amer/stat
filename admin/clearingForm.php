<?php
session_start();

if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])){

    include 'init.php'; 


      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($_POST['mdaate'] !=0 && $_POST['ydaate'] !=0) {
          $_SESSION['month'] = $_POST['mdaate'] . '-' . $_POST['ydaate'];
          $_SESSION['cardstate'] = $_POST['cardstate'];
          header('Location: ../report/clearing.php');
        } else {
          header('Location: clearingForm.php');
        }

      } else {
        $_SESSION['month'] = null;
        $_SESSION['cardstate'] = null;
      }


    
    
    ?>

    <div class="container">
        <form class="form-horizontal" action="clearingForm.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد التاريخ</label>
                <div class="col-md-3">
                  <select class="form-control" name="mdaate">
                    <option value="0">إختر ...</option>
                    <?php for($i = 1; $i <= 12;$i++):
                      if($i < 10) {
                        $date = '0' . $i;
                      } else {
                        $date = $i;
                      }
                    ?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="ydaate">
                    <option value="all">إختر ...</option>
                    <?php for($i = 2018; $i <= 2025;$i++):
                       $date = $i;?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; 
                    $statename = $_SESSION['statename'];
                    $rows = getAllFrom('ID, name', 'tables', "WHERE tnum = 11 ", " AND name != '$statename' ", 'ID', '');
                    
                    ?>

                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد الولايه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="cardstate">
                    <option value="all">كل الولايات</option>
                    <?php foreach ($rows as $row): ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>


                <div class="form-group form-group-md">
                    <div class="col-md-offset-3 col-md-6">
                        <input class="form-control btn-primary" type="submit" value="ادخال البيانات">
                    </div>
                </div>
            </div>

        </form>
    </div>

    <?php

    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
