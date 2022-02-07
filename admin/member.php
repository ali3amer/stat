<?php
  session_start();
  if(isset($_SESSION['admin']) || isset($_SESSION['superman'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';


    if($do == 'mange') {

      $rows = getAllFrom('users.*, city.name as city', 'users', 'INNER JOIN city ON city.ID = users.city WHERE status = 1 OR status = 2 OR status = 5', '', 'ID', '');

    ?>

      <div class="container">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>إسم المستخدم</th>
              <th>الإسم الكامل</th>
              <th>المحليه</th>
              <th>الصلاحيات</th>
              <th>التحكم</th>
            </tr>

            <?php foreach($rows as $row):?>

            <tr>
              <td><?php echo $row['username']; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td>
                <?php echo $row['city']; ?>
              </td>
              <td><?php if($row['status'] == 1) {echo "مستخدم";} elseif($row['status'] == 2) {echo "مدير نظام";} elseif($row['status'] == 5) {echo "مستعرض نقارير";} ?></td>
              <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <?php if($row['status'] == 1 || $row['status'] == 5) { ?><a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a><?php } ?></td>
            </tr>
          <?php endforeach; ?>
          </table>
          <a class="btn btn-primary" href="?do=add">إضافة مستخدم</a>
        </div>
      </div>



    <?php
    } elseif($do == 'add') {

      $citys = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');

    ?>

      <h1 class="text-center">إضافة مستخدم</h1>
      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم المستخدم :</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="name" autocomplete="off"  />
              </div>
            </div>

            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">كلمة المرور :</label>
              <div class="col-md-6">
                <input class="form-control" type="password" name="password" autocomplete="new-password"  />
              </div>
            </div>

            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">الإسم الكامل :</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="fullname" autocomplete="off"  />
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
              <label class="col-md-3 control-label">الصلاحيات :</label>
              <div class="col-md-6">
                <select class="form-control" name="status">
                  <option value="0">إختر...</option>
                  <option value="1">مستخدم</option>
                  <option value="2">مدير نظام</option>
                  <?php if(isset($_SESSION['superman'])) { ?>
                  <option value="3">منشئ النظام</option>
                <?php } ?>
                  <option value="4">ضابط تأمين</option>
                  <option value="5">مستعرض تقارير</option>
                </select>
              </div>
            </div>

            <div class="form-group form-group-md">
              <div class="col-md-offset-3 col-md-6">
                <input class="btn btn-primary btn-lg" type="submit" name="" value="حــفـــظ">
              </div>
            </div>

          </form>
        </div>
      </div>

    <?php } elseif($do == 'insert' ) {

      if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username    =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if($_POST['password'] != null) {
              $password    =  filter_var(sha1($_POST['password']), FILTER_SANITIZE_STRING);
            } else {
              header('Location: member.php?do=add');
            }
            $fullname    =  filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
            $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
            $status      =  filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);

            $checkuser = getOne('*', 'users', "WHERE username = '$username'", '', 'ID', '');

            if($checkuser == null && $username != null && $fullname != null && $city > 0 && $status > 0) {

              $stmt = $con->prepare("INSERT INTO
                                    users(username, password, fullname, status, state, city )
                                    VALUES(:name,:pass,:full, :status, :state, :city) ");

              $stmt->execute(array(

                              'name'         =>  $username,
                              'pass'         =>  $password,
                              'full'         =>  $fullname,
                              'status'       =>  $status,
                              'state'        =>  $_SESSION['state'],
                              'city'         =>  $city

                      ));

            $count = $stmt->rowCount();

            if($count > 0) { ?>

              <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
              header("refresh: 3; url = member.php");

              }

            } else {

              header("Location: member.php");

            }

          } else {

            header("Location: member.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'users', 'WHERE ID = ' . $id, '', 'ID', '');

        $citys = getAllFrom('*', 'city', '', '', 'ID', ''); ?>

        <h1 class="text-center">تعديل المستخدم</h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id ?>">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">إسم المستخدم :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" autocomplete="off" value="<?php echo $row['username'] ?>"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">كلمة المرور :</label>
                <div class="col-md-6">
                  <input class="form-control" type="password" name="password" autocomplete="new-password" value="<?php $row['password'] ?>"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">الاسم الكامل :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="fullname" autocomplete="off" value="<?php echo $row['fullname'] ?>"  />
                </div>
              </div>


              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">المحليه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="city">
                    <option value="0">إختر...</option>
                    <?php foreach($citys as $city): ?>
                    <option value="<?php echo $city['ID'] ?>" <?php if($row['city'] == $city['ID']) { echo "selected"; } ?>><?php echo $city['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>



              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">الصلاحيات :</label>
                <div class="col-md-6">
                  <select class="form-control" name="status">
                    <option value="0" <?php if($row['status'] == 0){echo "selected";} ?>>إختر ...</option>
                    <option value="1" <?php if($row['status'] == 1){echo "selected";} ?>>مستخدم</option>
                    <option value="2" <?php if($row['status'] == 2){echo "selected";} ?>>مدير نظام</option>
                    <option value="5" <?php if($row['status'] == 5){echo "selected";} ?>>مستعرض تقارير</option>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <div class="col-md-offset-3 col-md-6">
                  <input class="btn btn-primary btn-lg" type="submit" name="" value="تعــديل">
                </div>
              </div>

            </form>
          </div>
        </div>


      <?php
      } elseif($do == 'update') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

          $id          =  filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
          $username    =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
          $password    =  filter_var($_POST['password'], FILTER_SANITIZE_STRING);
          $fullname    =  filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
          $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
          $status      =  filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
          if($password == null || $password == '') {
            $row = getOne('password', 'users', 'WHERE ID = ' . $id, '', 'ID', '');
            $newpassword = $row['password'];
          } else {
            $newpassword = sha1($password);
          }

          if($username != null && $fullname != null && $city > 0 && $status > 0) {

            $stmt = $con->prepare("UPDATE users SET
                  username = ?, password = ?, fullname = ?, status = ?, city = ? WHERE ID = ? ");

            $stmt->execute(array($username, $newpassword, $fullname, $status, $city, $id));

          $count = $stmt->rowCount();

          if($count > 0) { ?>

            <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

            <?php
            header("refresh: 3; url = member.php");

          } else {
            header("Location: member.php");
          }

          } else {

            header("Location: member.php");

          }

            } else {

              header("Location: member.php");

            }


      } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM users WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = member.php");

        }

      }


?>



<?php

    include $tmp . 'footer.php';

  } else {

    header('Location: ../index.php');

    exite();



  }

?>
