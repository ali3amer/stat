<?php
  session_start();

  if(isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange') {

      $rows = getAllFrom('profsname.*, tables.name as profname', 'profsname', 'INNER JOIN tables ON tables.ID = profsname.prof WHERE state = ' . $_SESSION['state'], '', 'ID', '');

    ?>

      <div class="container">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>الإسم</th>
              <th>التخصص</th>
              <th>التحكم</th>
            </tr>
            <?php foreach($rows as $row):?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td>
                <?php echo $row['profname']; ?>
              </td>
              <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
            </tr>
          <?php endforeach; ?>
          </table>
          <a class="btn btn-primary" href="?do=add">إضافة اخصائي</a>
        </div>
      </div>

    <?php
    } elseif($do == 'add') { 
      
    $rows = getAllFrom('*', 'tables', 'WHERE tnum = 12 ', '', 'ID', '');  
      
    ?>

      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم الاخصائي :</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="name" autocomplete="off"  />
              </div>
            </div>


            <div class="form-group form-group-md">
                <label class="col-md-3 control-label">التخصص</label>
                <div class="col-md-6">
                    <select class="form-control" name="prof">
                    <option value="0">إختر ...</option>
                    <?php foreach($rows as $row): ?>   
                     <option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>

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

            $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $prof        =  filter_var($_POST['prof'], FILTER_SANITIZE_NUMBER_INT);
            if($name != null && $prof > 0) {

              $stmt = $con->prepare("INSERT INTO
                                     profsname(name, prof, state)
                                     VALUES(:name, :prof, :state) ");

               $stmt->execute(array(

                               'name'          =>  $name,
                               'prof'          =>  $prof,
                               'state'         =>  $_SESSION['state']
                       ));

             $count = $stmt->rowCount();

             if($count > 0) { ?>

               <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

               <?php
               header("refresh: 3; url = profs.php");

               }

            } else {

              header("Location: profs.php");

            }

          } else {

            header("Location: profs.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $name = getOne('*', 'profsname', 'WHERE ID = ' . $id, '', 'ID', '');
        $rows = getAllFrom('*', 'tables', 'WHERE tnum = 12 ', '', 'ID', '');  

        ?>

        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id ?>">

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">اسم الاخصائي :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" autocomplete="off" value="<?php echo $name['name'] ?>"  />
                </div>
              </div>

            <div class="form-group form-group-md">
                <label class="col-md-3 control-label">التخصص</label>
                <div class="col-md-6">
                    <select class="form-control" name="prof">
                    <option value="0">إختر ...</option>
                    <?php foreach($rows as $row): ?>   
                     <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $name['prof']){ echo 'selected'; } ?>><?php echo $row['name']; ?></option>

                    <?php endforeach; ?>
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

            $id        =  filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
            $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $prof        =  filter_var($_POST['prof'], FILTER_SANITIZE_NUMBER_INT);

              if($name != null && $prof > 0) {

                $stmt = $con->prepare("UPDATE profsname SET
                      name = ?, prof = ? WHERE ID = ? ");

                $stmt->execute(array($name, $prof, $id));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                <?php
                header("refresh: 3; url = profs.php");

                } else {

                  header("Location: profs.php");

                }

              }

            } else {

              header("Location: profs.php");

            }


      } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM profsname WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = profs.php");

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
