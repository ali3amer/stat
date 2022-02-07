<?php
session_start();


if((isset($_SESSION['admin']) && isset($_SESSION['daate'])) || isset($_SESSION['user'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    $daate = $_SESSION['daate']; ?>

    <div class="container alert alert-info"><ul><li><?php echo $daate; ?></li></ul></div>

    <?php

    if($do == 'mange') {


        $drows = getAllFrom('pharmacysum.*, pharmacy.name as name', 'pharmacysum', 'INNER JOIN pharmacy ON pharmacy.ID = pharmacysum.pharmacy WHERE pharmacysum.state = ' . $_SESSION['state'] . ' AND type = 1 ', " AND daate = '$daate' ", 'ID', '');

        $udrows = getAllFrom('pharmacysum.*, pharmacy.name as name', 'pharmacysum', 'INNER JOIN pharmacy ON pharmacy.ID = pharmacysum.pharmacy WHERE pharmacysum.state = ' . $_SESSION['state'] . ' AND type = 2 ', " AND daate = '$daate' ", 'ID', '');

        $derows = getAllFrom('pharmacysum.*, pharmacy.name as name', 'pharmacysum', 'INNER JOIN pharmacy ON pharmacy.ID = pharmacysum.pharmacy WHERE pharmacysum.state = ' . $_SESSION['state'] . ' AND type = 3 ', " AND daate = '$daate' ", 'ID', '');

        $hrows = getAllFrom('pharmacysum.*, pharmacy.name as name', 'pharmacysum', 'INNER JOIN pharmacy ON pharmacy.ID = pharmacysum.pharmacy WHERE pharmacysum.state = ' . $_SESSION['state'] . ' AND type = 4 ', " AND daate = '$daate' ", 'ID', '');

        $restor = getOne('*', 'restorcost', 'WHERE state = ' . $_SESSION['state'] . " AND daate = '$daate' ", '', 'ID', '');



        ?>




        <div class="container">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">الصدليات المباشره</a></li>
                <li><a data-toggle="tab" href="#menu1">الصدليات غير المباشره</a></li>
                <li><a data-toggle="tab" href="#menu2">الصدليات المتعاقد معها</a></li>
                <li><a data-toggle="tab" href="#menu3">صدليات المستشفيات</a></li>
                <li><a data-toggle="tab" href="#menu4">الإسترداد</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <?php if($drows != null){ ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>25%</th>
                                <th>75%</th>
                                <th>الدواء التجاري</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($drows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['freq']; ?>
                                    </td>
                                    <td><?php echo $row['quarter']; ?></td>
                                    <td><?php echo $row['three']; ?></td>
                                    <td><?php echo $row['medicincost']; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php }else{ ?>

                        <div class="container text-center alert alert-info">لم تتم إضافة بيانات</div>

                    <?php
                    } ?>
                </div>

                <div id="menu1" class="tab-pane fade">
                    <?php if($udrows != null){ ?>

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>25%</th>
                                <th>75%</th>
                                <th>الدواء التجاري</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($udrows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['freq']; ?>
                                    </td>
                                    <td><?php echo $row['quarter']; ?></td>
                                    <td><?php echo $row['three']; ?></td>
                                    <td><?php echo $row['medicincost']; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php }else{ ?>

                        <div class="container text-center alert alert-info">لم تتم إضافة بيانات</div>

                    <?php
                    } ?>
                </div>

                <div id="menu2" class="tab-pane fade">
                    <?php if($derows != null){ ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>25%</th>
                                <th>75%</th>
                                <th>الدواء التجاري</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($derows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['freq']; ?>
                                    </td>
                                    <td><?php echo $row['quarter']; ?></td>
                                    <td><?php echo $row['three']; ?></td>
                                    <td><?php echo $row['medicincost']; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php }else{ ?>

                        <div class="container text-center alert alert-info">لم تتم إضافة بيانات</div>

                    <?php
                    } ?>
                </div>

                <div id="menu3" class="tab-pane fade">
                    <?php if($hrows != null){ ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>25%</th>
                                <th>75%</th>
                                <th>الدواء التجاري</th>
                                <th>التحكم</th>
                            </tr>
                            <?php foreach($hrows as $row):?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <?php echo $row['freq']; ?>
                                    </td>
                                    <td><?php echo $row['quarter']; ?></td>
                                    <td><?php echo $row['three']; ?></td>
                                    <td><?php echo $row['medicincost']; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&id=<?php echo $row['ID'] ?>">تعديل</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php }else{ ?>

                        <div class="container text-center alert alert-info">لم تتم إضافة بيانات</div>

                    <?php
                    } ?>
                </div>

                <div id="menu4" class="tab-pane fade">
                    <?php if($restor != null){ ?>
                    <div class="table-responsive">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="restor" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>التردد</th>
                                    <th>التكلفة</th>
                                    <th>التحكم</th>
                                </tr>
                                <tr>
                                    <td><?php echo $restor['freq']; ?></td>
                                    <td><?php echo $restor['cost']; ?></td>
                                    <td><a class="btn btn-info" href="?do=edit&idr=<?php echo $restor['ID'] ?>">تعديل</a></td>

                                </tr>

                            </table>

                    </div>
                    <?php }else{ ?>

                        <div class="container text-center alert alert-info">لم تتم إضافة بيانات</div>

                    <?php
                    } ?>
                </div>
            </div>

        </div>

        <?php
    } elseif($do == 'add') {


        $drows = getAllFrom('*', 'pharmacy', 'WHERE type = 1', '', 'ID', '');
        $udrows = getAllFrom('*', 'pharmacy', 'WHERE type = 2', '', 'ID', '');
        $derows = getAllFrom('*', 'pharmacy', 'WHERE type = 3', '', 'ID', '');
        $hrows = getAllFrom('*', 'pharmacy', 'WHERE type = 4', '', 'ID', '');

        $crestor = checkrow('*', 'restorcost', 'WHERE state = ' . $_SESSION['state'] . " AND daate = '$daate' ", '', 'ID', '');

        ?>

        <div class="container">


            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">الصدليات المباشره</a></li>
                <li><a data-toggle="tab" href="#menu1">الصدليات غير المباشره</a></li>
                <li><a data-toggle="tab" href="#menu2">الصدليات المتعاقد معها</a></li>
                <li><a data-toggle="tab" href="#menu3">صدليات المستشفيات</a></li>
                <li><a data-toggle="tab" href="#menu4">الإسترداد</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                    <?php
                    if($drows != null) {
                    $isset = 0;
                    foreach($drows as $row) {
                        $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');
                        if($check == 0) {
                            $isset++;
                        }
                    }

                    if ($isset != 0) {

                    ?>
                    <div class="table-responsive">
                        <form class="form-horizontal" action="?do=insert" method="post">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="pharma" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>إسم الصيدلية</th>
                                    <th>التردد</th>
                                    <th>25%</th>
                                    <th>75%</th>
                                    <th>الدواء التجاري</th>
                                </tr>
                                <?php $i = 1; foreach($drows as $row):

                                    $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');

                                    if($check == 0) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <input type="hidden" name="<?php echo 'ID' . $i; ?>" value="<?php echo $row['ID']; ?>">
                                        <td>
                                            <input type="text" class="form-control" name="<?php echo 'freq' . $i; ?>" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control" name="<?php echo 'quarter' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'three' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'medicincost' . $i; ?>" autocomplete="off"></td>
                                    </tr>
                                    <?php
                                    }

                                    $i++; endforeach; ?>

                            </table>
                            <input class="btn btn-primary" type="submit" value="ادخال البيانات">
                        </form>

                    </div>
                        <?php } else { ?>

                        <div class="text-center alert alert-info">تم إدخال البيانات مسبقاً</div>

                        <?php
                     }
                    }  else { ?>

                        <div class="text-center alert alert-info">لاتوجد صيدليات</div>

                        <?php
                    } ?>

                </div>

                <div id="menu1" class="tab-pane fade">
                    <?php
                    if($udrows != null) {
                    $isset = 0;
                    foreach($udrows as $row) {
                        $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');
                        if($check == 0) {
                            $isset++;
                        }
                    }

                    if ($isset != 0) { ?>
                    <div class="table-responsive">
                        <form class="form-horizontal" action="?do=insert" method="post">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="pharma" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>إسم الصيدلية</th>
                                    <th>التردد</th>
                                    <th>25%</th>
                                    <th>75%</th>
                                    <th>الدواء التجاري</th>
                                </tr>
                                <?php $i = 1; foreach($udrows as $row):

                                    $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');

                                    if($check == 0) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <input type="hidden" name="<?php echo 'ID' . $i; ?>"
                                                   value="<?php echo $row['ID']; ?>">
                                            <td>
                                                <input type="text" class="form-control"
                                                       name="<?php echo 'freq' . $i; ?>" autocomplete="off">
                                            </td>
                                            <td><input type="text" class="form-control"
                                                       name="<?php echo 'quarter' . $i; ?>" autocomplete="off"></td>
                                            <td><input type="text" class="form-control"
                                                       name="<?php echo 'three' . $i; ?>" autocomplete="off"></td>
                                            <td><input type="text" class="form-control"
                                                       name="<?php echo 'medicincost' . $i; ?>" autocomplete="off"></td>
                                        </tr>
                                        <?php
                                    }
                                    $i++; endforeach; ?>

                            </table>
                            <input class="btn btn-primary" type="submit" value="ادخال البيانات">
                        </form>

                    </div>
                    <?php } else { ?>

                        <div class="text-center alert alert-info">تم إدخال البيانات مسبقاً</div>

                        <?php
                    }
                    } else { ?>

                            <div class="text-center alert alert-info">لاتوجد صيدليات</div>

                            <?php
                        } ?>
                </div>

                <div id="menu2" class="tab-pane fade">
                    <?php
                    if($derows != null) {
                    $isset = 0;
                    foreach($derows as $row) {
                        $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');
                        if($check == 0) {
                            $isset++;
                        }
                    }

                    if ($isset != 0) { ?>
                    <div class="table-responsive">
                        <form class="form-horizontal" action="?do=insert" method="post">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="pharma" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>إسم الصيدلية</th>
                                    <th>التردد</th>
                                    <th>25%</th>
                                    <th>75%</th>
                                    <th>الدواء التجاري</th>
                                </tr>
                                <?php $i = 1; foreach($derows as $row):

                                    $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');

                                    if($check == 0) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <input type="hidden" name="<?php echo 'ID' . $i; ?>" value="<?php echo $row['ID']; ?>">
                                        <td>
                                            <input type="text" class="form-control" name="<?php echo 'freq' . $i; ?>" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control" name="<?php echo 'quarter' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'three' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'medicincost' . $i; ?>" autocomplete="off"></td>
                                    </tr>
                                    <?php
                                    }

                                    $i++; endforeach; ?>

                            </table>
                            <input class="btn btn-primary" type="submit" value="ادخال البيانات">
                        </form>

                    </div>
                    <?php } else { ?>

                        <div class="text-center alert alert-info">تم إدخال البيانات مسبقاً</div>

                        <?php
                    }
                    }  else { ?>

                        <div class="text-center alert alert-info">لاتوجد صيدليات</div>

                        <?php
                    } ?>
                </div>

                <div id="menu3" class="tab-pane fade">
                    <?php
                    if($hrows != null) {
                    $isset = 0;
                    foreach($hrows as $row) {
                        $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');
                        if($check == 0) {
                            $isset++;
                        }
                    }

                    if ($isset != 0) { ?>
                    <div class="table-responsive">
                        <form class="form-horizontal" action="?do=insert" method="post">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="pharma" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>إسم الصيدلية</th>
                                    <th>التردد</th>
                                    <th>25%</th>
                                    <th>75%</th>
                                    <th>الدواء التجاري</th>
                                </tr>
                                <?php $i = 1; foreach($hrows as $row):
                                    $check = checkrow('ID', 'pharmacysum', 'WHERE pharmacy = ' . $row['ID'], " AND daate = '$daate' ", 'ID', '');

                                    if($check == 0) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <input type="hidden" name="<?php echo 'ID' . $i; ?>" value="<?php echo $row['ID']; ?>">
                                        <td>
                                            <input type="text" class="form-control" name="<?php echo 'freq' . $i; ?>" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control" name="<?php echo 'quarter' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'three' . $i; ?>" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" name="<?php echo 'medicincost' . $i; ?>" autocomplete="off"></td>
                                    </tr>
                                    <?php
                                    }
                                    $i++; endforeach; ?>

                            </table>
                            <input class="btn btn-primary" type="submit" value="ادخال البيانات">
                        </form>

                    </div>
                    <?php } else { ?>

                        <div class="text-center alert alert-info">تم إدخال البيانات مسبقاً</div>

                        <?php
                    }
                    }  else { ?>

                        <div class="text-center alert alert-info">لاتوجد صيدليات</div>

                        <?php
                    } ?>
                </div>

                <div id="menu4" class="tab-pane fade">
                    <?php if($crestor == 0) { ?>
                    <div class="table-responsive">
                        <form class="form-horizontal" action="?do=insert" method="post">
                            <input type="hidden" name="daate" value="<?php echo $daate; ?>">
                            <input type="hidden" name="restor" value="<?php echo 'ok'; ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>التردد</th>
                                    <th>التكلفة</th>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" name="<?php echo 'freq'; ?>" autocomplete="off"></td>                                       </td>
                                    <td><input type="text" class="form-control" name="<?php echo 'cost'; ?>" autocomplete="off"></td>
                                </tr>

                            </table>
                            <input class="btn btn-primary" type="submit" value="ادخال البيانات">
                        </form>

                    </div>
                    <?php } else { ?>

                    <div class="text-center alert alert-info">تم إدخال البيانات مسبقاً</div>

                    <?php
                    }
                    ?>
                </div>
            </div>





        </div>

    <?php } elseif($do == 'insert' ) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            if(isset($_POST['restor'])) {
                $freq = filter_var($_POST['freq'], FILTER_SANITIZE_NUMBER_INT);
                $cost = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);

                $stmt = $con->prepare("INSERT INTO
                                     restorcost(freq, cost, state, daate)
                                     VALUES(:freq, :cost, :state, :daate) ");

                $stmt->execute(array(

                    'freq'          => $freq,
                    'cost'          => $cost,
                    'state'         => $_SESSION['state'],
                    'daate'         => $daate
                ));

                $addcount = $stmt->rowCount();

                if($addcount > 0) { ?>

                    <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

                    <?php
                    header("refresh: 3; url = pharmacysum.php?do=add");

                }


            }



            if(isset($_POST['pharma'])) {

            $count = (count($_POST) - 2) / 5;

            $daate = $_POST['daate'];

            for ($i = 1; $i <= $count; $i++) {

                $pharmacy = filter_var($_POST['ID' . $i], FILTER_SANITIZE_NUMBER_INT);
                $freq = filter_var($_POST['freq' . $i], FILTER_SANITIZE_NUMBER_INT);
                $quarter = filter_var($_POST['quarter' . $i], FILTER_VALIDATE_FLOAT);
                $three = filter_var($_POST['three' . $i], FILTER_VALIDATE_FLOAT);
                $medicincost = filter_var($_POST['medicincost' . $i], FILTER_VALIDATE_FLOAT);


                    $stmt = $con->prepare("INSERT INTO
                                     pharmacysum(pharmacy, freq, quarter, three, medicincost, state, daate)
                                     VALUES(:pharmacy, :freq, :quarter, :three, :medicincost, :state, :daate) ");

                    $stmt->execute(array(

                        'pharmacy'      => $pharmacy,
                        'freq'          => $freq,
                        'quarter'       => $quarter,
                        'three'         => $three,
                        'medicincost'   => $medicincost,
                        'state'         => $_SESSION['state'],
                        'daate'         => $daate
                    ));

                    $addcount = $stmt->rowCount();

            }
            }

            if($addcount > 0) { ?>

                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

                <?php
                header("refresh: 3; url = pharmacysum.php?do=add");

            }


        } else {

            header("Location: city.php");

        }

    } elseif($do == 'edit') {

        if(isset($_GET['id'])){

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $row = getOne('pharmacysum.*, pharmacy.name as name', 'pharmacysum', 'INNER JOIN pharmacy ON pharmacy.ID = pharmacysum.pharmacy WHERE pharmacysum.ID = ' . $id . ' AND pharmacysum.state = ' . $_SESSION['state'], " AND daate = '$daate' ", 'ID', '');

        ?>

        <div class="container">
            <div class="table-responsive">
                <form class="form-horizontal" action="?do=update" method="post">
                    <input type="hidden" name="pharma" value="<?php echo 'ok'; ?>">
                    <table class="table table-bordered">
                        <tr>
                            <th>إسم الصيدلية</th>
                            <th>التردد</th>
                            <th>25%</th>
                            <th>75%</th>
                            <th>الدواء التجاري</th>
                        </tr>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <input type="hidden" name="<?php echo 'ID'; ?>" value="<?php echo $row['ID']; ?>">
                                <td>
                                    <input type="text" class="form-control" value="<?php echo $row['freq']; ?>" name="<?php echo 'freq'; ?>" autocomplete="off">
                                </td>
                                <td><input type="text" class="form-control" value="<?php echo $row['quarter']; ?>" name="<?php echo 'quarter'; ?>" autocomplete="off"></td>
                                <td><input type="text" class="form-control" value="<?php echo $row['three']; ?>" name="<?php echo 'three'; ?>" autocomplete="off"></td>
                                <td><input type="text" class="form-control" value="<?php echo $row['medicincost']; ?>" name="<?php echo 'medicincost'; ?>" autocomplete="off"></td>
                            </tr>

                    </table>
                    <input class="btn btn-primary" type="submit" value="حفـــــظ">
                </form>

            </div>
        </div>

    <?php } elseif(isset($_GET['idr'])) {

            $id = (isset($_GET['idr']) && is_numeric($_GET['idr'])) ? intval($_GET['idr']) : 0;

            $row = getOne('*', 'restorcost', 'WHERE ID = ' . $id . ' AND state = ' . $_SESSION['state'], " AND daate = '$daate' ", 'ID', '');

            ?>

            <div class="container">
                <div class="table-responsive">
                    <form class="form-horizontal" action="?do=update" method="post">
                        <input type="hidden" name="restor" value="<?php echo 'ok'; ?>">
                        <table class="table table-bordered">
                            <tr>
                                <th>التردد</th>
                                <th>التكلفة</th>
                            </tr>
                            <tr>
                                <input type="hidden" name="<?php echo 'ID'; ?>" value="<?php echo $row['ID']; ?>">
                                <td>
                                    <input type="text" class="form-control" value="<?php echo $row['freq']; ?>" name="<?php echo 'freq'; ?>" autocomplete="off">
                                </td>
                                <td><input type="text" class="form-control" value="<?php echo $row['cost']; ?>" name="<?php echo 'cost'; ?>" autocomplete="off"></td>
                            </tr>

                        </table>
                        <input class="btn btn-primary" type="submit" value="حفـــــظ">
                    </form>

                </div>
            </div>

            <?php
        }


        } elseif($do == 'update') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            if(isset($_POST['restor'])){

                $id = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
                $freq = filter_var($_POST['freq'], FILTER_SANITIZE_NUMBER_INT);
                $cost = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);

                $stmt = $con->prepare("UPDATE restorcost SET
                      freq = ?, cost = ? WHERE ID = ? ");

                $stmt->execute(array($freq, $cost, $id));

                $count = $stmt->rowCount();

                if($count > 0) { ?>

                    <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                    <?php
                    header("refresh: 3; url = pharmacysum.php");

                } else {

                    header("Location: pharmacysum.php");

                }
            }


            if(isset($_POST['pharma'])){

            $id = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
            $freq = filter_var($_POST['freq'], FILTER_SANITIZE_NUMBER_INT);
            $quarter = filter_var($_POST['quarter'], FILTER_VALIDATE_FLOAT);
            $three = filter_var($_POST['three'], FILTER_VALIDATE_FLOAT);
            $medicincost = filter_var($_POST['medicincost'], FILTER_VALIDATE_FLOAT);

                $stmt = $con->prepare("UPDATE pharmacysum SET
                      freq = ?, quarter = ?, three = ?, medicincost = ? WHERE ID = ? ");

                $stmt->execute(array($freq, $quarter, $three, $medicincost, $id));

                $count = $stmt->rowCount();

                if($count > 0) { ?>

                    <div class="container text-center alert alert-success">تم التعديل بنجاح</div>

                    <?php
                    header("refresh: 3; url = pharmacysum.php");

                } else {

                    header("Location: pharmacysum.php");

                }
                }

        } else {

            header("Location: pharmacysum.php");

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
