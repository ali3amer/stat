<?php
session_start();

if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

    include 'init.php';
    $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');

        $month = $_SESSION['month'];
        ?>

        <div class="container">
            <form class="form-horizontal" action="details.php" method="post">
                <div class="alert alert-info">
                    <ul>
                        <li><?php echo $rows['name']; ?></li>
                    </ul>
                </div>
                <div class="row">
                    <?php $rows = getAllFrom('DISTINCT(daate) as daate', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$month' ", 'ID', ''); ?>
                    <div class="form-group form-group-md">
                        <label class="col-md-3 control-label">حدد التاريخ</label>
                        <div class="col-md-6">
                            <select class="form-control" name="datedetails">
                                <option value="0">إختر ...</option>
                                <?php foreach ($rows as $row): ?>
                                    <option value="<?php echo $row['daate']; ?>"><?php echo $row['daate']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-md">
                        <div class="col-md-offset-3 col-md-6">
                            <input class="form-control btn-primary" type="submit" value="ادخال البيانات">
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <?php


    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
