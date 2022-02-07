<?php
  session_start();
  if(isset($_SESSION['admin']) && isset($_SESSION['state'])) {

      include 'init.php'; ?>

        <div class="container">
          <form class="form-horizontal" action="center.php?do=add" method="post">
            <div class="row">
              <?php $citys = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', ''); ?>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">أدخل عدد المراكز : </label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="number" autocomplete="off"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">المحليه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="city">
                    <option value="0">إختر...</option>
                    <?php foreach($citys as $city): ?>
                    <option value="<?php echo $city['ID'] ?>"><?php echo $city['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">التصنيف :</label>
                <div class="col-md-6">
                  <select class="form-control" name="category">
                    <option value="0">إختر...</option>
                    <option value="1">مستشفى</option>
                    <option value="2">مركز</option>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">النوع :</label>
                <div class="col-md-6">
                  <select class="form-control" name="type">
                    <option value="0">إختر...</option>
                    <option value="1">مباشر</option>
                    <option value="2">غير مباشر</option>
                    <option value="3">شراكة</option>
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
