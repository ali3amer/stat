<?php
  session_start();

  if(isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    $daate = $_SESSION['daate'];

    if($do == 'mange') {

      $rows = getAllFrom('census.*, city.name', 'census', "INNER JOIN city ON census.city = city.ID WHERE daate = '$daate' " , '', 'ID', '');

    ?>

      <div class="container">
      <?php if($rows != null){ ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>المحليه</th>
              <th>عدد السكان</th>
              <th>التحكم</th>
            </tr>
            <?php $sum = 0; foreach($rows as $row): $sum += $row['census']; ?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td>
                <?php echo $row['census']; ?>
              </td>
              <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>&city=<?php echo $row['city'] ?>">تعديل</a></td>
            </tr>
          <?php endforeach; ?>

          <tr>
            <th>المجموع</th>
            <th><?php echo $sum; ?></th>
            <th></th>
          </tr>

          </table>
          
        </div>
    <?php } else { ?>

  <div class="text-center alert alert-info">لم تتم إضافة تعداد للعام <?php echo $daate ?></div>
<a class="btn btn-primary" href="?do=add">إضافة</a>
    <?php } ?>
      </div>

    <?php
    } elseif($do == 'add') { 
        
        $rows = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');
        ?>

      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <div class="container">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                    <th>المحليه</th>
                    <th>عدد السكان</th>
                    </tr>
                    <?php foreach($rows as $row):?>
                    <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>" >
                    <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <input type="text" class="form-control" name="<?php echo 'city_' . $row['ID'] ?>" autocomplete="off" >
                    </td>
                    </tr>
                <?php endforeach; ?>
                </table>
                </div>
            </div>

            <input class="btn btn-primary" type="submit" name="" value="حــفـــظ">

          </form>
        </div>
      </div>

    <?php } elseif($do == 'insert' ) {

        $rows = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');


      if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $counter = count($rows);

        $i = 0;

        foreach($rows as $row) {

            $id     = $row['ID'];
        
            $census = filter_var($_POST['city_' . $id], FILTER_VALIDATE_FLOAT);

              $stmt = $con->prepare("INSERT INTO
                                     census(city, census, daate)
                                     VALUES(:city, :census, :daate) ");

               $stmt->execute(array(

                               'city'          =>  $id,
                               'census'        =>  $census,
                               'daate'         =>  $_SESSION['daate']
                       ));

             $count = $stmt->rowCount();
             $i++;

        }

             if($count = $i++) { ?>

               <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

               <?php
               header("refresh: 3; url = census.php");

               }



          } else {

            header("Location: census.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $cityid = (isset($_GET['city']) && is_numeric($_GET['city'])) ? intval($_GET['city']) : 0;

        $row = getOne('*', 'census', 'WHERE ID = ' . $id, '', 'ID', '');

        $city = getOne('*', 'city', 'WHERE ID = ' . $cityid, '', 'ID', '');



        ?>

        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input type="hidden" name="ID" value="<?php echo $id ?>">

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label"> تعداد محلية <?php echo $city['name'];  ?> :</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="census" autocomplete="off" value="<?php echo $row['census'] ?>"  />
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
              $census      =  filter_var($_POST['census'], FILTER_SANITIZE_NUMBER_INT);

                $stmt = $con->prepare("UPDATE census SET
                      census = ? WHERE ID = ? ");

                $stmt->execute(array($census, $id));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                <?php
                header("refresh: 3; url = census.php");

                } else {

                  header("Location: census.php");

                }


            } else {

              header("Location: census.php");

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
