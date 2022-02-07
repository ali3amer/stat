<?php
  session_start();
  if(isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';


    if($do == 'mange') {

      $rows = getAllFrom('center.*, city.name as city, unit.name as unitname', 'center', 'INNER JOIN city ON city.ID = center.city INNER JOIN unit ON unit.ID = center.unit', '', 'ID', '');
      if($rows != null) {
    ?>

      <div class="container">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>إسم المركز</th>
              <th>المحليه</th>
              <th>الوحدة الإدارية</th>
              <th>التصنيف</th>
              <th>النوع</th>
              <th>التحكم</th>
            </tr>

            <?php foreach($rows as $row):?>

            <tr>
              <td><?php echo $row['name']; ?></td>
              <td>
                <?php
                  echo $row['city'];
                ?>
              </td>
              <td><?php echo $row['unitname']; ?></td>
              <td><?php if($row['category'] == 1) { echo "مستشفى"; } elseif($row['category'] == 2) {echo "مركز";} ?></td>
              <td><?php if($row['type'] == 1) { echo "مباشر"; } elseif($row['type'] == 2) {echo "غير مباشر";} elseif($row['type'] == 3) {echo "شراكه";} ?></td>
              <td><a class="btn btn-info" href="updatecenter.php?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
            </tr>
          <?php endforeach; ?>
          </table>
          <a class="btn btn-primary" href="?do=add">إضافة مركز</a>
        </div>
      </div>

    <?php
  } else { ?>
    <div class="container">
      <div class="alert alert-info text-center">لم تتم إضافة مراكز حتى الأن</div>
      <a class="btn btn-primary" href="?do=add">إضافة مركز</a>
    </div>
  <?php }
    } elseif($do == 'add') {

      $citys = getAllFrom('*', 'city', '', '', 'ID', '');

    ?>

      <h1 class="text-center">إضافة مركز</h1>
      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <?php if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $units = getAllFrom('*', 'unit', 'WHERE city = ' . $_POST['city'], '', 'ID', '');

            if($_POST['number'] > 0 && $_POST['city'] > 0 && $_POST['category'] > 0 && $_POST['type'] > 0) { ?>
              <input name="number" type="hidden" value="<?php echo $_POST['number'] ?>" />
              <input name="city" type="hidden" value="<?php echo $_POST['city'] ?>" />
              <input name="category" type="hidden" value="<?php echo $_POST['category'] ?>" />
              <input name="type" type="hidden" value="<?php echo $_POST['type'] ?>" />
              <?php
              for($i = 1; $i <= $_POST['number']; $i++) {
            ?>
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم المركز :</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="<?php echo "name" . $i; ?>" autocomplete="off"  />
              </div>
            </div>


            <div class="form-group form-group-md">
               <label class="col-md-3 control-label">الوحدة الإدارية :</label>
               <div class="col-md-6">
                  <select class="form-control" name="unit">
                     <option value="0">إختر...</option>
                        <?php foreach($units as $unit): ?>
                           <option value="<?php echo $unit['ID'] ?>"><?php echo $unit['name'] ?></option>
                        <?php endforeach; ?>
                  </select>
               </div>
            </div>

          <?php
         }
        } else {
            header('Location: addcenterform.php');
          }
        } else {
            header('Location: addcenterform.php');
          } ?>


            <div class="form-group form-group-md">
              <div class="col-md-offset-3 col-md-6">
                <input class="btn btn-primary btn-lg" type="submit" value="حــفـــظ">
              </div>
            </div>

          </form>
        </div>
      </div>

    <?php } elseif($do == 'insert' ) {

      if($_SERVER['REQUEST_METHOD'] == 'POST') {


            for($i = 1; $i <= $_POST['number']; $i++) {

            $name        =  filter_var($_POST['name' . $i], FILTER_SANITIZE_STRING);
            $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
            $unit        =  filter_var($_POST['unit'], FILTER_SANITIZE_NUMBER_INT);
            $category    =  filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            $type        =  filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);
            if($name != null && $city > 0 && $category > 0 && $type > 0) {

                $stmt = $con->prepare("INSERT INTO
                                      center(name, state, city, unit, category, type )
                                      VALUES(:name, :state, :city, :unit, :category, :type) ");

                $stmt->execute(array(

                                'name'       =>  $name,
                                'state'      =>  $_SESSION['state'],
                                'city'       =>  $city,
                                'unit'       =>  $unit,
                                'category'   =>  $category,
                                'type'       =>  $type

                        ));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success"><?php echo $i ."/تمت الاضافة بنجاح"; ?></div>

                <?php

              } else { ?>

                <div class="container text-center alert alert-danger"><?php echo $i ."/لم تتم الإضافه"; ?></div>

                <?php
              }

            }
          }

          header("refresh: 3; url = center.php");


          } else {

            header("Location: center.php");

          }

      } elseif($do == 'edit') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

          if(isset($_POST['city']) && $_POST['city'] > 0) {

        $id = (isset($_POST['id']) && is_numeric($_POST['id'])) ? intval($_POST['id']) : 0;

        $row = getOne('*', 'center', 'WHERE ID = ' . $id, '', 'ID', '');

        echo $city =$_POST['city'];

        $units = getAllFrom('*', 'unit', 'WHERE city = ' . $city, '', 'ID', '');


 ?>

        <h1 class="text-center">تعديل مركز</h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id ?>">
              <input type="hidden" name="city" value="<?php echo $city ?>">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">إسم المركز :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off"  />
                </div>
              </div>

                <div class="form-group form-group-md">
                    <label class="col-md-3 control-label">الوحدة الإدارية :</label>
                    <div class="col-md-6">
                        <select class="form-control" name="unit">
                            <option value="0">إختر...</option>
                            <?php foreach($units as $unit): ?>
                                <option value="<?php echo $unit['ID'] ?>" <?php if($unit['ID'] == $row['unit']){echo 'selected';} ?>><?php echo $unit['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">التصنيف :</label>
                <div class="col-md-6">
                  <select class="form-control" name="category">
                    <option value="0">إختر...</option>
                    <option value="1" <?php if($row['category'] == 1){echo 'selected';} ?> >مستشفى</option>
                    <option value="2" <?php if($row['category'] == 2){echo 'selected';} ?> >مركز</option>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">النوع :</label>
                <div class="col-md-6">
                  <select class="form-control" name="type">
                    <option value="0">إختر...</option>
                    <option value="1" <?php if($row['type'] == 1){echo 'selected';} ?> >مباشر</option>
                    <option value="2" <?php if($row['type'] == 2){echo 'selected';} ?>>غير مباشر</option>
                    <option value="3" <?php if($row['type'] == 3){echo 'selected';} ?>شراكه</option>
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
          } else {
        header('Location: updatecenter.php');
      }
      } else {
        header('Location: center.php');
      }
      
    } elseif($do == 'update') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

          $id          =  filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
          $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
          $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
          $unit        =  filter_var($_POST['unit'], FILTER_SANITIZE_NUMBER_INT);
          $category    =  filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
          $type        =  filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);

          if($name != null && $city > 0 && $category > 0 && $type > 0 && $unit > 0) {

            $stmt = $con->prepare("UPDATE center SET
                  name = ?, city = ?, unit = ?, category = ?, type = ? WHERE ID = ? ");

            $stmt->execute(array($name, $city, $unit, $category, $type, $id));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                <?php
                header("refresh: 3; url = center.php");

                } else {

                  header("Location: center.php");

                }

              }else {

              header("Location: center.php");

            }

            } else {

              header("Location: center.php");

            }

      } elseif($do == 'delete') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM center WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if ($count > 0) {
          echo "<div class='container'><div class='text-center alert alert-success'>تم الحذف بنجاح</div></div>";
          header("refresh: 3; url = center.php");
        }
      }

    include $tmp . 'footer.php';

  } else {

    header('Location: ../index.php');

    exite();

  }

?>
