<?php
  session_start();
  if(isset($_SESSION['admin']) || isset($_SESSION['superman'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';


    if($do == 'mange') {

      $citys = getAllFrom('ID, name', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');

      foreach($citys as $city):

        $rows = getAllFrom('centeruser.*, users.username, users.fullname, center.name as center', 'centeruser', 'INNER JOIN users ON users.ID = centeruser.user INNER JOIN center ON center.ID = centeruser.center WHERE centeruser.city = ' . $city['ID'], '', 'ID', '');

    ?>

      <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo 'محلية : ' . $city['name']; ?></div>
          <div class="panel-body">
            <div class="table-responsive">
              <?php if($rows != null) { ?>
              <table class="table table-bordered">
                <tr>
                  <th>إسم المستخدم</th>
                  <th>الإسم الكامل</th>
                  <th>المركز</th>
                  <th>التحكم</th>
                </tr>

                <?php foreach($rows as $row):?>

                <tr>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td>
                    <?php echo $row['center']; ?>
                  </td>
                  <td> <a class="btn btn-info" href="member.php?do=edit&id=<?php echo $row['user'] ?>">تعديل</a>  <a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger confirm" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                </tr>
              <?php endforeach; ?>
              </table>
            <?php } else { ?>

                <div class="alert alert-info">لم تتم إضافة بيانات حتى الان</div>

          <?php } ?>
              <a class="btn btn-primary" href="?do=add&city=<?php echo $city['ID']; ?>">إضافة ضابط تأمين</a>
            </div>
          </div>
        </div>

      </div>


    <?php

  endforeach;


    } elseif($do == 'add') {

      $city = (isset($_GET['city']) && is_numeric($_GET['city'])) ? intval($_GET['city']) : 0;

      $centers = getAllFrom('*', 'center', 'WHERE city = ' . $city, '', 'ID', '');
      $users = getAllFrom('ID, fullname', 'users', 'WHERE city = ' . $city, ' AND status = 4', 'ID', '');

    ?>

      <h1 class="text-center">إضافة ضابط تأمين</h1>
      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <input type="hidden" name="city" value="<?php echo $city ?>">
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم المستخدم :</label>
              <div class="col-md-6">
                <select class="form-control" name="user">
                  <option value="0">إختر...</option>
                  <?php foreach($users as $user): ?>
                  <option value="<?php echo $user['ID'] ?>"><?php echo $user['fullname'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">المركز :</label>
              <div class="col-md-6">
                <select class="form-control" name="center">
                  <option value="0">إختر...</option>
                  <?php foreach($centers as $center): ?>
                  <option value="<?php echo $center['ID'] ?>"><?php echo $center['name'] ?></option>
                  <?php endforeach; ?>
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

            $city    =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
            $user    =  filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT);
            $center  =  filter_var($_POST['center'], FILTER_SANITIZE_NUMBER_INT);

            if($user != null && $city > 0 && $center > 0) {

              $stmt = $con->prepare("INSERT INTO
                                    centeruser(user, city, center )
                                    VALUES(:name, :city, :center) ");

              $stmt->execute(array(

                              'name'         =>  $user,
                              'city'         =>  $city,
                              'center'       =>  $center

                      ));

            $count = $stmt->rowCount();

            if($count > 0) { ?>

              <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
              header("refresh: 3; url = centeruser.php");

              }

            } else {

              header("Location: centeruser.php");

            }

          } else {

            header("Location: centeruser.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row      = getOne('*', 'centeruser', 'WHERE ID = ' . $id, '', 'ID', '');
        $centers  = getAllFrom('*', 'center', 'WHERE city = ' . $row['city'], '', 'ID', '');
        $users    = getAllFrom('ID, fullname', 'users', 'WHERE city = ' . $row['city'], ' AND status = 4', 'ID', '');

 ?>

        <h1 class="text-center">تعديل ضابط التأمين</h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">إسم المستخدم :</label>
                <div class="col-md-6">
                  <select class="form-control" name="user">
                    <option value="0">إختر...</option>
                    <?php foreach($users as $user): ?>
                    <option value="<?php echo $user['ID']; ?>" <?php if($row['user'] == $user['ID']) { echo "selected"; } ?> ><?php echo $user['fullname'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">المركز :</label>
                <div class="col-md-6">
                  <select class="form-control" name="center">
                    <option value="0">إختر...</option>
                    <?php foreach($centers as $center): ?>
                    <option value="<?php echo $center['ID'] ?>" <?php if($row['center'] == $center['ID']) { echo "selected"; } ?>><?php echo $center['name'] ?></option>
                    <?php endforeach; ?>
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


      <?php
      } elseif($do == 'update') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

          $id          =  filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
          $user        =  filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT);
          $center      =  filter_var($_POST['center'], FILTER_SANITIZE_NUMBER_INT);

          if($user > 0 && $center > 0) {

            $stmt = $con->prepare("UPDATE centeruser SET
                  user = ?, center = ? WHERE ID = ? ");

            $stmt->execute(array($user, $center, $id));

          $count = $stmt->rowCount();

          if($count > 0) { ?>

            <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

            <?php
            header("refresh: 3; url = centeruser.php");

          } else {
            header("Location: centeruser.php");
          }

          } else {

            header("Location: centeruser.php");

          }

            } else {

              header("Location: member.php");

            }


      } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM centeruser WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = centeruser.php");

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
