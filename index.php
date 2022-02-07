<?php
  session_start();

  $nonavbar = '';

  if(isset($_SESSION['user'])) {

    header('Location: userhome.php');
    exite();

  } elseif(isset($_SESSION['admin']) || isset($_SESSION['superman']) || isset($_SESSION['mreports'])) {
    header('Location: admin/dashboard.php');
    exite();
  } elseif(isset($_SESSION['centeruser'])) {
    header('Location: centeruser/selectcenter.php');
    exite();
  }

  include 'init.php';

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if($count > 0) {

      $msg = '';

      $_SESSION['username'] = $username;
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['state'] = $row['state'];
      $state = getOne('name', 'state', 'WHERE ID = ' . $row['state'], '', 'ID', '');
      $_SESSION['statename'] = $state['name'];
      if($row['status'] == 2) {
        $_SESSION['admin'] = $row['status'];
        
        header('Location: admin/dashboard.php');

      } elseif($row['status'] == 1) {
        $_SESSION['user'] = $row['status'];
        $_SESSION['city'] = $row['city'];
        header('Location: userhome.php');

      } elseif($row['status'] == 3) {
      $_SESSION['superman'] = $row['status'];
      header('Location: admin/dashboard.php');

    } elseif($row['status'] == 4) {
      $centr = getOne('*', 'centeruser', 'WHERE user = ' . $row['ID'], '', 'ID', '');
      if($centr != null) {
      $_SESSION['centeruser'] = $row['status'];
      $_SESSION['city'] = $row['city'];
      $_SESSION['state'] = $row['state'];
      $_SESSION['centerusername'] = $centr['user'];
      header('Location: centeruser/selectcenter.php');

    }
    } elseif($row['status'] == 5) {
      $_SESSION['mreports'] = $row['status'];
      header('Location: admin/dashboard.php');

    }
    } else {
      $msg = "<div class='alert alert-danger'>عفواً إسم المستخدم أو الكلمة المرور الذين أدخلتهما غير صحيحين</div>";
    }

  }

?>

<div class="container">
  <div class="login-page">

    <div class="row">
      <div class="col-md-6">

        <form class="login text-center" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <h4 class="text-center">تسجيل دخول</h4>
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="username" placeholder="إسم المستخدم" autocomplete="off">
          </div>

          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input type="password" class="form-control" name="password" placeholder="كلمة المرور" autocomplete="new-password">
          </div>

          <input class="form-control btn-primary submit" type="submit" name="submit" value="تسجيل دخول">
          <?php if(isset($msg)){echo $msg;} ?>
        </form>
      </div>
      <div class="col-md-6">
        <img src="layout/img/الشماليه.jpg" alt="">
      </div>
    </div>
</div>
</div>




<?php

  include $tmp . 'footer.php';

?>
