<?php
  session_start();
  if(isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    $arrayTable = array(

      '1'   => '1/التردد حسب الفئات العمريه',
      '2'   =>  '2/التردد والتكلفه حسب القطاعات',
      '3'   =>  '3/التردد والتكلفه لخدمات الاسنان والانف والاذن والحنجره',
      '4'   =>  '4/التردد والتكلفه حسب الامراض المختلفه',
      '5'   =>  '5/التردد والتكلفه حسب الامراض المزمنه',
      '6'   =>  '6/خدمات خاصه بمرضى السكري',
      '7'   =>  '7/التردد والتكلفه حسب المستوى الاول',
      '8'   =>  '8/التردد والتكلفه والاحاله للاختصاصيين',
      '9'   =>  '9/التردد على العمليات والخدمات السريريه والتقويم',
      '10'  =>  '10/التردد على الفحوصات المعمليه والتشخيصيه',
      '11'  =>  '11/التردد للبطاقه القوميه حسب الولايات',
      '12'  =>  '12/تفاصيل الاحاله على خدمات الاختصاصيين',
      '13'  =>  '13/الترددوجملة تردد الدواء والامراض المزمنه',
      '14'  =>  '14/تفاصيل الإحالة على خدمة الإختصاصيين خارج الولاية',
      '15'  =>  '15/تفاصيل الاحاله على خدمة الاختصاصيين داخل المحليه',
      '16'  =>  '16/تفاصيل الفحوصات المعمليه بالعينات',
      '17'  =>  '17/تردد قوات الشرطه واسرهم على منافذ الخدمه'

    );

    if($do == 'mange') {

    ?>

      <div class="tables-section">
        <div class="container">
          <div class="row">

        <?php
        for ($i = 1; $i <= 16; $i++) {
            if($i != 13) {
                $rows = getAllFrom('ID,name', 'tables', 'WHERE tnum = ' . $i, '', 'ID', ''); ?>

                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2"><?php echo $arrayTable[$i] ?></th>
                            </tr>
                            <tr>
                                <th>القطاع</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a>
                                        <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

                <?php
            }
        }

      ?>

          </div>

          <a class="btn btn-primary" href="?do=add">إضافة الى جدول</a>
        </div>
      </div>



    <?php
    } elseif($do == 'add') { ?>

      <h1 class="text-center">إضافة حقل</h1>
      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="?do=insert" method="post">
            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">إسم الحقل</label>
              <div class="col-md-6">
                <input class="form-control" type="text" name="name" autocomplete="off"  />
              </div>
            </div>

            <div class="form-group form-group-md">
              <label class="col-md-3 control-label">حدد الجدول :</label>
              <div class="col-md-6">
                <select class="form-control" name="tnum">
                  <option value="0">إختر ...</option>
                  <?php for($i = 1; $i <= 17; $i++){ ?>
                  <option value="<?php echo $i; ?>"><?php echo $arrayTable[$i]; ?></option>
                  <?php } ?>
                  
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

            $name    =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $tnum    =  filter_var($_POST['tnum'], FILTER_SANITIZE_NUMBER_INT);

            if($name !=null && $tnum > 0) {

              $stmt = $con->prepare("INSERT INTO
                                    tables(name, tnum)
                                    VALUES(:name,:tnum) ");

              $stmt->execute(array(

                              'name'      =>  $name,
                              'tnum'      =>  $tnum

                      ));

            $count = $stmt->rowCount();

            if($count > 0) { ?>

              <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
              header("refresh: 3; url = tables.php");

              }

            } else {

                header("Location: tables.php");

            }

          } else {

            header("Location: tables.php");

          }

      } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'tables', 'WHERE ID = ' . $id, '', 'ID', '');?>

        <h1 class="text-center">تعديل حقل</h1>
        <div class="container">
          <div class="row">
            <form class="admin form-horizontal" action="?do=update" method="post">
              <input class="form-control" type="hidden" name="ID" value="<?php echo $row['ID']; ?>" />
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">إسم الحقل</label>
                <div class="col-md-6">
                  <input class="form-control" type="text" name="name" value="<?php echo $row['name']; ?>" autocomplete="off"  />
                </div>
              </div>

              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد المحليه :</label>
                <div class="col-md-6">
                  <select class="form-control" name="tnum">
                    <option value="0">إختر ...</option>
                    <?php for($i = 1; $i <= 16; $i++){ ?>
                    <option value="<?php echo $i; ?>" <?php if($row['tnum'] == $i){echo "selected";} ?>><?php echo $arrayTable[$i]; ?></option>
                    <?php } ?>
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
              $id          =  filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
              $name        =  filter_var($_POST['name'], FILTER_SANITIZE_STRING);
              $tnum        =  filter_var($_POST['tnum'], FILTER_SANITIZE_NUMBER_INT);

              if($name != null && $tnum > 0) {

                $stmt = $con->prepare("UPDATE tables SET
                      name = ?, tnum = ? WHERE ID = ? ");

                $stmt->execute(array($name, $tnum, $id));

              $count = $stmt->rowCount();

              if($count > 0) { ?>

                <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                <?php
                header("refresh: 3; url = tables.php");

                }

              } else {

                  header("Location: tables.php");

              }

            } else {

              header("Location: tables.php");

            }

      } elseif($do == 'delete') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM tables WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

          <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

          <?php
          header("refresh: 3; url = tables.php");

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
