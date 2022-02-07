<?php
  session_start();
  if(isset($_SESSION['centeruser'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';


    if($do == 'mange') {

      $rows = getAllFrom('client.*', 'client', '', '', 'ID', '');

    ?>

      <div class="container">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>رقم التأمين</th>
              <th>الإسم</th>
              <th>النوع</th>
              <th>المخدم</th>
              <th>القطاع</th>
              <th>الصفه</th>
              <th>العمر</th>
              <th>ولاية البطاقه</th>
            </tr>

            <?php foreach($rows as $row):

              $gender = array(
                          '1' => 'ذكر',
                          '2' => 'انثى'
                        );

              $adjective = array(
                          '1' => 'مؤمن',
                          '2' => 'معال'
                        );


            ?>


            <tr>
              <td><?php echo $row['nhifid']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $gender[$row['gender']]; ?></td>
              <td><?php echo $row['server']; ?></td>
              <?php $sector = getOne('name', 'tables', 'WHERE ID = ' . $row['sector'], '', 'ID', ''); ?>
              <td><?php echo $sector['name']; ?></td>
              <td><?php echo $adjective[$row['adjective']]; ?></td>
              <?php $age = getOne('name', 'tables', 'WHERE ID = ' . $row['age'], '', 'ID', ''); ?>
              <td><?php echo $age['name']; ?></td>
              <?php $card = getOne('name', 'tables', 'WHERE ID = ' . $row['cardstate'], '', 'ID', ''); ?>
              <td><?php echo $card['name'] ?></td>
            </tr>

            <?php endforeach; ?>
          </table>
          <a class="btn btn-primary" href="?do=add">إضافة</a>
        </div>
      </div>



    <?php
    } elseif($do == 'add') {

    ?>

      <h1 class="text-center">إضافة مؤمن عليه</h1>
      <div class="container">
        <?php
        addClient("client.php?do=insert");
        ?>
      </div>

    <?php } elseif($do == 'insert' ) {

      if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nhif = checkrow('nhifid', 'client', 'WHERE nhifid = ' . $_POST['nhifid'], '' ,'ID', '');
            if($nhif > 0) { ?>
              <div class="container text-center alert alert-danger">عفواً هذا الشخص موجود بالفعل</div>

            <?php
            header("refresh: 3; url = client.php?do=add");

            } else {

              $nhifid      =  filter_var($_POST['nhifid'], FILTER_SANITIZE_NUMBER_INT);
              $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
              $gender      =  filter_var($_POST['gender'], FILTER_SANITIZE_NUMBER_INT);
              $server      =  filter_var($_POST['server'], FILTER_SANITIZE_STRING);
              $sector      =  filter_var($_POST['sector'], FILTER_SANITIZE_NUMBER_INT);
              $adjective   =  filter_var($_POST['adjective'], FILTER_SANITIZE_NUMBER_INT);
              $age         =  filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
              $cardstate   =  filter_var($_POST['cardstate'], FILTER_SANITIZE_NUMBER_INT);


              if($nhifid > 0 && $name != null && $server != null && $gender > 0 && $sector > 0 && $adjective > 0 && $age > 0 && $cardstate > 0) {

                $stmt = $con->prepare("INSERT INTO
                                      client(nhifid, name, gender, server, sector, adjective, age, cardstate )
                                      VALUES(:nh,:n, :g, :s, :sec, :ad, :age, :cardstate) ");

                $stmt->execute(array(

                                'nh'        =>  $nhifid,
                                'n'         =>  $name,
                                'g'         =>  $gender,
                                's'         =>  $server,
                                'sec'       =>  $sector,
                                'ad'        =>  $adjective,
                                'age'       =>  $age,
                                'cardstate' =>  $cardstate

                        ));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

                <?php
                header("refresh: 1; url = visit.php?do=$nhifid");

                }

              } else {

                header("Location: client.php?do=add");

              }

            }

          } else {

            header("Location: client.php?do=add");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row      = getOne('*', 'client', 'WHERE ID = ' . $id, '', 'ID', '');
        $sectors  = getAllFrom('*', 'tables', 'WHERE tnum = 2', '', 'ID', '');
        $ages     = getAllFrom('*', 'tables', 'WHERE tnum = 1', '', 'ID', '');
        $states   = getAllFrom('*', 'tables', 'WHERE tnum = 11', '', 'ID', '');

        ?>

        <h1 class="text-center">تعديل المستخدم</h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id; ?>">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">رقم التأمين :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" maxlength=11 minlength=11 name="nhifid" value="<?php echo $row['nhifid'] ?>" autocomplete="off" required  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">الإسم :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">الجنس :</label>
                <div class="col-md-6">
                  <select class="form-control" name="gender">
                    <option value="0">إختر...</option>
                    <option value="1" <?php if($row['gender'] == 1) { echo "selected"; } ?> >ذكر</option>
                    <option value="2" <?php if($row['gender'] == 2) { echo "selected"; } ?>>انثى</option>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">المخدم :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="server" value="<?php echo $row['server'] ?>" autocomplete="off"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">القطاع :</label>
                <div class="col-md-6">
                  <select class="form-control" name="sector">
                    <option value="0">إختر...</option>
                    <?php foreach($sectors as $sector): ?>
                    <option value="<?php echo $sector['ID'] ?>" <?php if($row['sector'] == $sector['ID']) { echo "selected"; } ?> ><?php echo $sector['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">الصفه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="adjective">
                    <option value="0">إختر...</option>
                    <option value="1" <?php if($row['gender'] == 1) { echo "selected"; } ?> >مؤمن</option>
                    <option value="2" <?php if($row['gender'] == 2) { echo "selected"; } ?> >معال</option>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">العمر :</label>
                <div class="col-md-6">
                  <select class="form-control" name="age">
                    <option value="0">إختر...</option>
                    <?php foreach($ages as $age): ?>
                    <option value="<?php echo $age['ID'] ?>" <?php if($row['age'] == $age['ID']) { echo "selected"; } ?> ><?php echo $age['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">ولاية البطاقه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="cardstate">
                    <option value="0">إختر...</option>
                    <?php foreach($states as $state): ?>
                    <option value="<?php echo $state['ID'] ?>" <?php if($row['cardstate'] == $state['ID']) { echo "selected"; } ?> ><?php echo $state['name'] ?></option>
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

          $nhif = checkrow('nhifid', 'client', 'WHERE nhifid = ' . $_POST['nhifid'], ' AND ID != ' . $_POST['ID'] ,'ID', '');
          if($nhif > 0) { ?>
            <div class="container text-center alert alert-danger">عفواً هذا الشخص موجود بالفعل</div>

          <?php
          header("refresh: 3; url = client.php?do=edit&id=".$_POST['ID']);

        } else {

          $id          =  filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
          $nhifid      =  filter_var($_POST['nhifid'], FILTER_SANITIZE_NUMBER_INT);
          $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
          $gender      =  filter_var($_POST['gender'], FILTER_SANITIZE_NUMBER_INT);
          $server      =  filter_var($_POST['server'], FILTER_SANITIZE_STRING);
          $sector      =  filter_var($_POST['sector'], FILTER_SANITIZE_NUMBER_INT);
          $adjective   =  filter_var($_POST['adjective'], FILTER_SANITIZE_NUMBER_INT);
          $age         =  filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
          $cardstate   =  filter_var($_POST['cardstate'], FILTER_SANITIZE_NUMBER_INT);

          if($nhifid > 0 && $name != null && $server != null && $gender > 0 && $sector > 0 && $adjective > 0 && $age > 0 && $cardstate > 0) {

            $stmt = $con->prepare("UPDATE client SET
                  nhifid = ?, name = ?, gender = ?, server = ?, sector = ?, adjective = ?, age = ?, cardstate = ? WHERE ID = ? ");

            $stmt->execute(array($nhifid, $name, $gender, $server, $sector, $adjective, $age, $cardstate, $id));

          $count = $stmt->rowCount();

          if($count > 0) { ?>

            <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

            <?php
            header("refresh: 1; url = visit.php?do=$nhifid");

          } else {
            header("Location: client.php");
          }

          } else {

            header("Location: client.php");

          }

        }

      } else {

        header("Location: client.php");

      }


      } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM users WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = client.php");

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
