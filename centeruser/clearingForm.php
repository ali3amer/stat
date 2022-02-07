<?php
session_start();

if(isset($_SESSION['centeruser'])){

    include 'init.php'; 


      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $_SESSION['cardstate'] = $_POST['cardstate'];
        header('Location: clearing.php');

          
      } else {
        $_SESSION['cardstate'] = null;
      }

      $statename = $_SESSION['statename'];

    
      $rows = getAllFrom('ID, name', 'tables', "WHERE tnum = 11 ", " AND name != '$statename' ", 'ID', '');

    ?>

    <div class="container">
        <form class="form-horizontal" action="clearingForm.php" method="post">
            <div class="row">

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
