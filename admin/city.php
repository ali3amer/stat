<?php
  session_start();

  if(isset($_SESSION['superman'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange') {

      $rows = getAllFrom('city.*, state.name as state', 'city', 'INNER JOIN state ON state.ID = city.state', '', 'ID', '');

    ?>

      <div class="container">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>المحليه</th>
              <th>الولايه</th>
              <th>التحكم</th>
            </tr>
            <?php foreach($rows as $row):?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td>
                <?php echo $row['state']; ?>
              </td>
              <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
            </tr>
          <?php endforeach; ?>
          </table>
          <a class="btn btn-primary" href="?do=add">إضافة محلية</a>
        </div>
      </div>

    <?php
    } elseif($do == 'add') { ?>

      <h1 class="text-center">إضافة محلية</h1>
      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم المحليه :</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="name" autocomplete="off"  />
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

            $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if($name != null) {

              $stmt = $con->prepare("INSERT INTO
                                     city(name, state)
                                     VALUES(:name, :state) ");

               $stmt->execute(array(

                               'name'          =>  $name,
                               'state'         =>  $_SESSION['state']
                       ));

             $count = $stmt->rowCount();

             if($count > 0) { ?>

               <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

               <?php
               header("refresh: 3; url = city.php");

               }

            } else {

              header("Location: city.php");

            }

          } else {

            header("Location: city.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'city', 'WHERE ID = ' . $id, '', 'ID', '');

        ?>

        <h1 class="text-center">تعديل محلية <?php echo $row['name']; ?></h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id ?>">

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">اسم المحليه :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" autocomplete="off" value="<?php echo $row['name'] ?>"  />
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
              $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);

              if($name != null) {

                $stmt = $con->prepare("UPDATE city SET
                      name = ?, state = ? WHERE ID = ? ");

                $stmt->execute(array($name, $_SESSION['state'], $id));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                <?php
                header("refresh: 3; url = city.php");

                } else {

                  header("Location: city.php");

                }

              }

            } else {

              header("Location: city.php");

            }


      } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM city WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = city.php");

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
