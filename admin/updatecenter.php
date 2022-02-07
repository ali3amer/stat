<?php
  session_start();
  if(isset($_SESSION['admin']) && isset($_SESSION['state'])) {

      include 'init.php'; 

      $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'center', 'WHERE ID = ' . $id, '', 'ID', '');

        $citys = getAllFrom('*', 'city', '', '', 'ID', '');
      
      ?>

        <div class="container">
          <form class="form-horizontal" action="center.php?do=edit" method="post">
          <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="row">
              <?php $citys = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', ''); ?>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">المحليه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="city">
                    <option value="0">إختر...</option>
                    <?php foreach($citys as $city): ?>
                    <option value="<?php echo $city['ID'] ?>" <?php if($row['city'] == $city['ID']){echo 'selected';} ?>><?php echo $city['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>


              <div class="form-group form-group-md">
                <div class="col-md-offset-3 col-md-6">
                  <input class="form-control btn-primary" type="submit" value="ادخال البيانات">
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
