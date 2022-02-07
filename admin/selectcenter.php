<?php
  session_start();
  if((isset($_SESSION['admin']) || isset($_SESSION['mreports'])) && isset($_SESSION['city'])) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['center']) && $_POST['center'] != 0 && $_POST['center'] != null && $_POST['mdaate'] != 0 && $_POST['ydaate'] != 0) {
          $_SESSION['center'] = $_POST['center'];
          $_SESSION['daate'] = $_POST['mdaate'] . '-' . $_POST['ydaate'];
          header('Location: ../report/centerreport.php');
        } else {

          header('Location: selectcenter.php');
          exite();
        }
      } else {
        $_SESSION['center'] = null;
      }

      include 'init.php';

        $rows = getAllFrom('ID, name', 'center', 'WHERE city = ' . $_SESSION['city'], '', 'ID', '');?>

        <div class="container">
          <form class="form-horizontal" action="selectcenter.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد المركز :</label>
                <div class="col-md-6">
                  <select class="form-control" name="center">
                    <option value="0">إختر ...</option>
                    <?php foreach ($rows as $row): ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>


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
                    <option value="0">إختر ...</option>
                    <?php for($i = 2018; $i <= 2025;$i++):
                       $date = $i;?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

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

  header('Location: index.php');
  exite();

}

?>
