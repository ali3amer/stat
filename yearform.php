<?php
session_start();
if(isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    include 'init.php'; ?>

    <div class="container">
        <form class="form-horizontal" action="cityreport/year.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد التاريخ</label>
                <div class="col-md-6">
                  <select class="form-control" name="daate">
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

    header('Location: ../index.php');
    exite();

}

?>
