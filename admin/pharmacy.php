<?php
session_start();

if(isset($_SESSION['admin']) || isset($_SESSION['user'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange') {

        $drows = getAllFrom('pharmacy.*, state.name as statep', 'pharmacy', 'INNER JOIN state ON state.ID = pharmacy.state', ' AND type = 1 ', 'ID', '');

        $udrows = getAllFrom('pharmacy.*, state.name as statep', 'pharmacy', 'INNER JOIN state ON state.ID = pharmacy.state', ' AND type = 2 ', 'ID', '');

        $derows = getAllFrom('pharmacy.*, state.name as statep', 'pharmacy', 'INNER JOIN state ON state.ID = pharmacy.state', ' AND type = 3 ', 'ID', '');

        $hrows = getAllFrom('pharmacy.*, state.name as statep', 'pharmacy', 'INNER JOIN state ON state.ID = pharmacy.state', ' AND type = 4 ', 'ID', '');




        $typeArray = array(

            '1'     => 'مباشرة',
            '2'     =>  'غير مباشرة',
            '3'     =>  'متعاقد معها',
            '4'     =>  'صيدلية مستشفى'

        );


        ?>

        <div class="container">


            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">الصدليات المباشره</a></li>
                <li><a data-toggle="tab" href="#menu1">الصدليات غير المباشره</a></li>
                <li><a data-toggle="tab" href="#menu2">الصدليات المتعاقد معها</a></li>
                <li><a data-toggle="tab" href="#menu3">صدليات المستشفيات</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                    <?php if($drows != null) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>الولاية</th>
                                <th>النوع</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($drows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['statep']; ?>
                                    </td>
                                    <td><?php echo $typeArray[$row['type']]; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                    <?php } else { ?>


                    <div class="alert alert-info text-center"> عفواً لم تتم إضافة صيدليات</div>


                <?php
                    } ?>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <?php if($udrows != null) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>المحلية</th>
                                <th>النوع</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($udrows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['statep']; ?>
                                    </td>
                                    <td><?php echo $typeArray[$row['type']]; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>
                <?php } else { ?>


                    <div class="alert alert-info text-center"> عفواً لم تتم إضافة صيدليات</div>


                    <?php
                } ?>
                <div id="menu2" class="tab-pane fade">
                    <?php if($derows != null) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>الولاية</th>
                                <th>النوع</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($derows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['statep']; ?>
                                    </td>
                                    <td><?php echo $typeArray[$row['type']]; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                    <?php } else { ?>


                        <div class="alert alert-info text-center"> عفواً لم تتم إضافة صيدليات</div>


                        <?php
                    } ?>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <?php if($hrows != null) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>الولاية</th>
                                <th>النوع</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($hrows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['statep']; ?>
                                    </td>
                                    <td><?php echo $typeArray[$row['type']]; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a> <a class="btn btn-danger" href="?do=delete&id=<?php echo $row['ID'] ?>">حذف</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                    <?php } else { ?>


                        <div class="alert alert-info text-center"> عفواً لم تتم إضافة صيدليات</div>


                        <?php
                    } ?>
                </div>
            </div>



            <a class="btn btn-primary" href="?do=add">إضافة </a>
        </div>

        <?php
    } elseif($do == 'add') {

        ?>

        <h1 class="text-center">إضافة صيدلية</h1>
        <div class="container">
            <div class="row">
                <form class="admin form-horizontal" action="?do=insert" method="post">
                    <?php if($_SERVER['REQUEST_METHOD'] == 'POST') {

                        if($_POST['number'] > 0 && $_POST['type'] > 0) { ?>
                            <input name="number" type="hidden" value="<?php echo $_POST['number'] ?>" />
                            <input name="type" type="hidden" value="<?php echo $_POST['type'] ?>" />
                            <?php
                            for($i = 1; $i <= $_POST['number']; $i++) {
                                ?>
                                <div class="form-group form-group-md">
                                    <label class="col-md-3 control-label">إسم الصيدلية :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="<?php echo "name" . $i; ?>" autocomplete="off"  />
                                    </div>
                                </div>

                                <?php
                            }
                        } else {
                            header('Location: addpharmacyform.php');
                        }
                    } else {
                        header('Location: addpharmacyform.php');
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


        for($i = 1; $i <= $_POST['number']; $i++) {

            $name        =  filter_var($_POST['name' . $i], FILTER_SANITIZE_STRING);
            $type        =  filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);
            if($name != null && $type > 0) {

                $stmt = $con->prepare("INSERT INTO
                                      pharmacy(name, state, type )
                                      VALUES(:name,:state, :type) ");

                $stmt->execute(array(

                    'name'       =>  $name,
                    'state'      =>  $_SESSION['state'],
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

        header("refresh: 3; url = pharmacy.php");


    } elseif($do == 'edit') {

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('*', 'pharmacy', 'WHERE ID = ' . $id, '', 'ID', '');
        ?>

        <h1 class="text-center">تعديل صيدلية</h1>
        <div class="container">
            <div class="row">
                <form class="admin form-horizontal" action="?do=update" method="post">
                    <input type="hidden" name="ID" value="<?php echo $id ?>">
                    <div class="form-group form-group-md">
                        <label class="col-md-3 control-label">إسم المركز :</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off"  />
                        </div>
                    </div>

                    <div class="form-group form-group-md">
                        <label class="col-md-3 control-label">النوع :</label>
                        <div class="col-md-6">
                            <select class="form-control" name="type">
                                <option value="0">إختر...</option>
                                <option value="1" <?php if($row['type'] == 1){echo 'selected';} ?>>مباشرة</option>
                                <option value="2" <?php if($row['type'] == 2){echo 'selected';} ?>>غير مباشرة</option>
                                <option value="3" <?php if($row['type'] == 3){echo 'selected';} ?>>متعاقد معها</option>
                                <option value="4" <?php if($row['type'] == 4){echo 'selected';} ?>>صيديلة مستشفى</option>
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
            $type        =  filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);

            if($name != null && $city > 0 && $type > 0 && $unit > 0) {

                $stmt = $con->prepare("UPDATE pharmacy SET
                  name = ?, type = ? WHERE ID = ? ");

                $stmt->execute(array($name, $type, $id));

                $count = $stmt->rowCount();

                if($count > 0) { ?>

                    <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                    <?php
                    header("refresh: 3; url = pharmacy.php");

                } else {

                    header("Location: pharmacy.php");

                }

            }

        } else {

            header("Location: pharmacy.php");

        }

    } elseif($do == 'delete') {


        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM pharmacy WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($count > 0) { ?>

            <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

            <?php
            header("refresh: 3; url = pharmacy.php");

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
