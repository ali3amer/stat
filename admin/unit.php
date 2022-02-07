<?php
session_start();

if(isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange') {

        $rows = getAllFrom('unit.*, city.name as cityname', 'unit', 'INNER JOIN city ON city.ID = unit.city', '', 'ID', '');

        ?>

        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>الوحدة الإدارية</th>
                        <th>المحلية</th>
                        <th>التحكم</th>
                    </tr>
                    <?php foreach($rows as $row):?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <?php echo $row['cityname']; ?>
                            </td>
                            <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a class="btn btn-primary" href="?do=add">إضافة وحدة إدارية</a>
            </div>
        </div>

        <?php
    } elseif($do == 'add') {

       $citys = getAllFrom('*', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');
    ?>

        <h1 class="text-center">إضافة وحدة إدارية</h1>
        <div class="container">
            <div class="row">
                <form class="admin form-horizontal" action="?do=insert" method="post">
                    <div class="form-group form-group-md">
                        <label class="col-md-3 control-label">إسم الوحدة الإدارية :</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="name" autocomplete="off"  />
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

            $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
            if($name != null) {

                $stmt = $con->prepare("INSERT INTO
                                     unit(name, city)
                                     VALUES(:name, :city) ");

                $stmt->execute(array(

                    'name'          =>  $name,
                    'city'          =>  $city

                ));

                $count = $stmt->rowCount();

                if($count > 0) { ?>

                    <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

                    <?php
                    header("refresh: 3; url = unit.php");

                }

            } else {

                header("Location: city.php");

            }

        } else {

            header("Location: unit.php");

        }

    } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'unit', 'WHERE ID = ' . $id, '', 'ID', '');
        $citys = getAllFrom('*', 'city', '', '', 'ID', '');

        ?>

        <h1 class="text-center">تعديل وحدة  <?php echo $row['name']; ?></h1>
        <div class="container">
            <div class="row">
                <form class="admin form-horizontal" action="?do=update" method="post">
                    <input type="hidden" name="ID" value="<?php echo $id ?>">

                    <div class="form-group form-group-md">
                        <label class="col-md-3 control-label">اسم الوحدة الإدارية :</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="name" autocomplete="off" value="<?php echo $row['name'] ?>"  />
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
            $city        =  filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);

            if($name != null) {

                $stmt = $con->prepare("UPDATE unit SET
                      name = ?, city = ? WHERE ID = ? ");

                $stmt->execute(array($name, $city, $id));

                $count = $stmt->rowCount();

                if($count > 0) { ?>

                    <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                    <?php
                    header("refresh: 3; url = unit.php");

                } else {

                    header("Location: unit.php");

                }

            }

        } else {

            header("Location: unit.php");

        }


    } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM unit WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

            <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

            <?php
            header("refresh: 3; url = unit.php");

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
