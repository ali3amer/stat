<?php
session_start();
if(isset($_SESSION['centeruser'])) {

    include 'init.php';  

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if($_POST['table'] == 'eyes') {
          $id       = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
          $name     = filter_var($_POST['name'], FILTER_SANITIZE_NUMBER_INT);
          $cost     = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);
          $servcost = filter_var($_POST['servcost'], FILTER_VALIDATE_FLOAT);
          $jobcost  = filter_var($_POST['jobcost'], FILTER_VALIDATE_FLOAT);

          $stmt = $con->prepare("UPDATE eyes SET
                            eye = ?, cost = ?, servcost = ?, jobcost = ?  WHERE ID = ?");

          $stmt->execute(array($name, $cost, $servcost, $jobcost, $id));

        } elseif($_POST['table'] == 'medcin') {

          $id       = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
          $cost     = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);

          $stmt = $con->prepare("UPDATE medcin SET
                            cost = ?  WHERE ID = ?");

          $stmt->execute(array($cost, $id)); 

        } else {
          $table = $_POST['table'];

          if($table == 'ills') {
              $filed = 'ill';
          } else {
              $filed = $table;
          }
          $id       = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
          $name     = filter_var($_POST['name'], FILTER_SANITIZE_NUMBER_INT);
          if($table == 'defrent') {
            $cost     = filter_var($_POST['cost'], FILTER_SANITIZE_STRING);
          } else {
            $cost     = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);
          }

          $stmt = $con->prepare("UPDATE $table SET
                            $filed = ?, cost = ? WHERE ID = ?");

          $stmt->execute(array($name, $cost, $id));
        } ?>

        <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

        <?php

        header('refresh: 2; url = ' . $_SESSION['urldir']); 

        
    
    } else { 

    $table = (isset($_GET['table']) && is_string($_GET['table'])) ? $_GET['table'] : '';

    $tnum = (isset($_GET['tnum']) && is_numeric($_GET['tnum'])) ? intval($_GET['tnum']) : 0;

    $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

    $names = getAllFrom('*', 'tables', 'WHERE tnum = ' . $tnum, '', 'ID', '');

    
    $row = getOne('*', "$table", 'WHERE ID = ' . $id, '', 'ID', '');  
    
    if($table == 'eyes'){
    
    ?>

      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="updateproccess.php" method="post">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group form-group-md">
              <div class="col-md-4">
                <select class="form-control" name="name">
                  <option value="0">إختر...</option>
                  <?php foreach($names as $name): ?>
                  <option value="<?php echo $name['ID'] ?>" <?php if($row['eye'] == $name['ID']) { echo 'selected'; } ?>><?php echo $name['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-2">
                <input class="form-control" type="text" placeholder="التكلفه" name="cost" value="<?php echo $row['cost']; ?>" autocomplete="off"  />
              </div>

              <div class="col-md-2">
                <input class="form-control" type="text" placeholder="تكلفة الخدمات" name="servcost" value="<?php echo $row['servcost']; ?>" autocomplete="off"  />
              </div>

              <div class="col-md-2">
                <input class="form-control" type="text" placeholder="تكلفة العمليات" name="jobcost" value="<?php echo $row['jobcost']; ?>" autocomplete="off"  />
              </div>

              <div class="col-md-2">
                <input class="btn btn-primary" type="submit" name="" value="حــفـــظ">
              </div>
            </div>

          </form>
        </div>
      </div>


    <?php

    } elseif($table == 'medcin') {
        ?>

      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="updateproccess.php" method="post">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group form-group-md">


              <div class="col-md-4">
                <input class="form-control" type="text" placeholder="التكلفة" value="<?php echo $row['cost']; ?>" name="cost" autocomplete="off"  />
              </div>

              <div class="col-md-4">
                <input class="btn btn-primary" type="submit" name="" value="حــفـــظ">
              </div>
            </div>

          </form>
        </div>
      </div>


    <?php
    } else {
        ?>

      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="updateproccess.php" method="post">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group form-group-md">
              <div class="col-md-4">
                <select class="form-control" name="name">
                  <option value="0">إختر...</option>
                  <?php 
                  
                  if($table == 'ills') {
                      $filed = 'ill';
                  } else {
                      $filed = $table;
                  }
                  
                  foreach($names as $name): ?>
                  <option value="<?php echo $name['ID'] ?>" <?php if($row[$filed] == $name['ID']) { echo 'selected'; } ?>><?php echo $name['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-4">
              <?php $placeHolder = ($table == 'defrent') ? 'التشخيص' : 'التكلفة' ?>
                <input class="form-control" type="text" placeholder="<?php echo $placeHolder; ?>" value="<?php echo $row['cost']; ?>" name="cost" autocomplete="off"  />
              </div>

              <div class="col-md-4">
                <input class="btn btn-primary" type="submit" name="" value="حــفـــظ">
              </div>
            </div>

          </form>
        </div>
      </div>


    <?php
    }
}

    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
