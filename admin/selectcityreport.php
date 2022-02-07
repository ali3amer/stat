<?php
  session_start();
  if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if(isset($_POST['city']) && $_POST['city'] != 0 && $_POST['city'] != null) {
        $_SESSION['city'] = $_POST['city'];
        header('Location: selectcenter.php');
        exite();
      } else {

        header('Location: selectcityreport.php');
        exite();
      }
    } else {
      $_SESSION['city'] = null;
    }

      include 'init.php';

        $rows = getAllFrom('ID, name', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');?>

        <div class="container">
          <form class="form-horizontal" action="selectcityreport.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد المحلية :</label>
                <div class="col-md-6">
                  <select class="form-control" name="city">
                    <option value="0">إختر ...</option>
                    <?php foreach ($rows as $row): ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
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
