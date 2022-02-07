<?php
session_start();
if(isset($_SESSION['admin']) && isset($_SESSION['state'])) {

    include 'init.php'; ?>

    <div class="container">
        <form class="form-horizontal" action="pharmacy.php?do=add" method="post">
            <div class="row">

                <div class="form-group form-group-md">
                    <label class="col-md-3 control-label">أدخل عدد الصيدليات : </label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="number" autocomplete="off"  />
                    </div>
                </div>

                <div class="form-group form-group-md">
                    <label class="col-md-3 control-label">النوع :</label>
                    <div class="col-md-6">
                        <select class="form-control" name="type">
                            <option value="0">إختر...</option>
                            <option value="1">مباشره</option>
                            <option value="2">غير مباشره</option>
                            <option value="3">متعاقد معها</option>
                            <option value="4">صيديلة مستشفى</option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-group-md">
                    <div class="col-md-offset-3 col-md-6">
                        <input class="form-control btn-primary" type="submit" value="ادخال البيانات">
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
