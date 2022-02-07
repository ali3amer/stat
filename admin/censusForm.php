<?php
session_start();

if(isset($_SESSION['admin'])){

    include 'init.php'; 


      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($_POST['daate'] !=0) {
          $_SESSION['daate'] = $_POST['daate'];
          header('Location: census.php');
        } else {
          header('Location: censusForm.php');
        }

      } else {
        $_SESSION['daate'] = null;
      }


    
    
    ?>

    <div class="container">
        <form class="form-horizontal" action="censusForm.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد التاريخ</label>

                <div class="col-md-6">
                  <select class="form-control" name="daate">
                    <option value="all">إختر ...</option>
                    <?php for($i = 2018; $i <= 2025;$i++):
                       $date = $i;?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; 
                    $statename = $_SESSION['statename'];                    
                    ?>

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
