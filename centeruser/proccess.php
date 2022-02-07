<?php

session_start();

if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

  include 'init.php';

  $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');

  $do = filter_var($_GET['do'], FILTER_SANITIZE_STRING);

  if($do == 'meet') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $meets = $meets = getAllFrom('*', 'tables', 'WHERE tnum = 7', '', 'ID', '');
      $daate = date('Y-m-d h:i');
      foreach ($meets as $meet) {
        if(isset($_POST[$meet['ID']])) {

          $cost   = filter_var($_POST['cost_' . $meet['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    meet(visit, meet, cost, daate )
                                    VALUES(:visit, :meet, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'meet'      =>  $_POST[$meet['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif($cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد المقابله</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif ($do == 'check') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $checks = getAllFrom('*', 'tables', 'WHERE tnum = 10', '', 'ID', '');
      $daate = date('Y-m-d h:i');
      foreach ($checks as $check) {
        if(isset($_POST[$check['ID']])) {

          $cost   = filter_var($_POST['cost_' . $check['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    checks(visit, checks, cost, daate )
                                    VALUES(:visit, :checks, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'checks'    =>  $_POST[$check['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif($cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد الفحص</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif ($do == 'ill') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $ills = getAllFrom('*', 'tables', 'WHERE tnum = 5', '', 'ID', '');
      $daate = date('Y-m-d h:i');

      foreach ($ills as $ill) {
        if(isset($_POST[$ill['ID']])) {

          $cost   = filter_var($_POST['cost_' . $ill['ID']], FILTER_VALIDATE_FLOAT);
  
            $stmt = $con->prepare("INSERT INTO
                                    ills(visit, ill, cost, daate )
                                    VALUES(:visit, :ill, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'ill'       =>  $_POST[$ill['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد المرض</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif ($do == 'proccess') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $proccess = getAllFrom('*', 'tables', 'WHERE tnum = 9', '', 'ID', '');
      $daate = date('Y-m-d h:i');

      foreach ($proccess as $procces) {
        if(isset($_POST[$procces['ID']])) {

          $cost   = filter_var($_POST['cost_' . $procces['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    proccess(visit, procces, cost, daate )
                                    VALUES(:visit, :procces, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'procces'   =>  $_POST[$procces['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif($cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد العملية</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif ($do == 'eyes') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $eyes = getAllFrom('*', 'tables', 'WHERE tnum = 3', '', 'ID', '');
      $daate = date('Y-m-d h:i');

      foreach ($eyes as $eye) {
        if(isset($_POST[$eye['ID']])) {

          $cost     = filter_var($_POST['cost_' . $eye['ID']], FILTER_VALIDATE_FLOAT);
          $servcost = filter_var($_POST['servcost_' . $eye['ID']], FILTER_VALIDATE_FLOAT);
          $jobcost  = filter_var($_POST['jobcost_' . $eye['ID']], FILTER_VALIDATE_FLOAT);
          $serve  = filter_var($_POST['eye_' . $eye['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    eyes(visit, eye, cost, servcost, jobcost, serve, daate )
                                    VALUES(:visit, :eye, :cost, :servcost, :jobcost, :serve, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'eye'       =>  $_POST[$eye['ID']],
                            'cost'      =>  $cost,
                            'servcost'  =>  $servcost,
                            'jobcost'   =>  $jobcost,
                            'serve'     =>  $serve,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif(cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد الخدمة</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif($do == 'defrents') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $defrents = getAllFrom('*', 'tables', 'WHERE tnum = 4', '', 'ID', '');
      $daate = date('Y-m-d h:i');

      foreach ($defrents as $defrent) {
        if(isset($_POST[$defrent['ID']])) {

          $cost   = filter_var($_POST['cost_' . $defrent['ID']], FILTER_SANITIZE_STRING);
  
            $stmt = $con->prepare("INSERT INTO
                                    defrent(visit, defrent, cost, daate )
                                    VALUES(:visit, :defrent, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'defrent'   =>  $_POST[$defrent['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد التشخييص</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif($do == 'suger') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $sugers = getAllFrom('*', 'tables', 'WHERE tnum = 6', '', 'ID', '');
      $daate  = date('Y-m-d h:i');

      foreach ($sugers as $suger) {
        if(isset($_POST[$suger['ID']])) {

          $cost   = filter_var($_POST['cost_' . $suger['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    suger(visit, suger, cost, daate )
                                    VALUES(:visit, :suger, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'suger'    =>  $_POST[$suger['ID']],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif($cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد الخدمة</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif($do == 'prof') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $profs = getAllFrom('*', 'tables', 'WHERE tnum = 12', '', 'ID', '');
      $daate  = date('Y-m-d h:i');

      foreach ($profs as $prof) {
        if(isset($_POST[$prof['ID']]) && $_POST['prof_' . $prof['ID']] > 0) {

          $cost     = filter_var($_POST['cost_' . $prof['ID']], FILTER_VALIDATE_FLOAT);
          $profname   = filter_var($_POST['prof_' . $prof['ID']], FILTER_VALIDATE_FLOAT);

          if($cost != null || $cost == 0 && $profname > 0){
  
            $stmt = $con->prepare("INSERT INTO
                                    prof(visit, prof, cost, profname, daate )
                                    VALUES(:visit, :prof, :cost, :profname, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'prof'    =>  $_POST[$prof['ID']],
                            'cost'      =>  $cost,
                            'profname'  =>  $profname,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } else { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        } else { ?>

            <div class="container text-center alert alert-danger">يجب تحديد الاختصاصي</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }
      
      }

    } 
  } elseif($do = 'medcin') {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $daate  = date('Y-m-d h:i');

        if(isset($_POST['cost'])) {

          $cost   = filter_var($_POST['cost'], FILTER_VALIDATE_FLOAT);

          if($cost != null){
  
            $stmt = $con->prepare("INSERT INTO
                                    medcin(visit, cost, daate )
                                    VALUES(:visit, :cost, :daate) ");
  
            $stmt->execute(array(
  
                            'visit'     =>  $_POST['visit'],
                            'cost'      =>  $cost,
                            'daate'     =>  $daate
  
            )); 

            header("Location: visit.php?do=" . $_POST['client']);

          } elseif($cost == null || $cost == 0) { ?>

            <div class="container text-center alert alert-danger">لا يمكن ترك التكلفه فارغه</div>

          <?php

          header("refresh: 2; url = visit.php?do=" . $_POST['client']);

          }

        }

    } 
  }


?>


<?php

  include $tmp . 'footer.php';
} else {
  header('Location: selectcenter.php');
}
?>
