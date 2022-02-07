<?php
  session_start();
  $pageTitle = 'تقرير محلية';
  if(isset($_SESSION['user']) || isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {

    $nonavbar = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      if(isset($_SESSION['city']) && $_SESSION['city'] != 0 && $_SESSION['city'] != null) {

        $date = $_POST['mdaate'] . '-' . $_POST['ydaate'];

      } elseif(isset($_POST['city']) && $_POST['city'] != 0 && $_POST['mdaate'] != 0 && $_POST['ydaate'] != 0) {

        $_SESSION['city'] = $_POST['city'];
        $date = $_POST['mdaate'] . '-' . $_POST['ydaate'];

      } else {
        if(isset($_SESSION['user'])) {
        header('Location: ../citydate.php');
      } elseif(isset($_SESSION['admin'])) {
        header('Location: ../admin/selectcity.php');
      }
      }

    if(isset($_SESSION['city'])) {

        include 'init.php';

        $cityname = getOne('name', 'city', 'WHERE ID = ' . $_SESSION['city'], '', 'ID', '');




      $one  = checkrow('DISTINCT(tnum)', 'summ', "WHERE daate = '$date' ", 'AND city = ' . $_SESSION['city'], 'ID', '');
      $two  = checkrow('DISTINCT(tnum)', 'summt', "WHERE daate = '$date' ", 'AND city = ' . $_SESSION['city'], 'ID', '');
      $three  = checkrow('DISTINCT(tnum)', 'freq', "WHERE daate = '$date' ", 'AND city = ' . $_SESSION['city'], 'ID', '');
      $checkcenters  = checkrow('DISTINCT(center)', 'summ', "WHERE daate = '$date' ", 'AND city = ' . $_SESSION['city'], 'ID', '');
      $centers  = checkrow('ID', 'center', 'WHERE city = ' . $_SESSION['city'], '', 'ID', '');
      if(($one + $two + $three) > 12) {

 ?>

          <div class="report">
            بسم الله الرحمن الرحيم <br />
            الصندوق القومي للتأمين الصحي <br />
            إدارة التخطيط <br />
            قسم الإحصاء <br />
            <u><?php echo 'تقرير محلية :' . $cityname['name'] . ' لشهر ' . $date; ?></u>
          </div>


          <div class="container reports">



              <?php




              $query = "center.city = " . $_SESSION['city'];

              $query2 = " AND daate = '$date'";

              $querydate = " AND daate = '$date' AND city = " . $_SESSION['city'];

              duhReport($query, $query2, $querydate);

              centerDetails($query, $query2);

              allCenters($query, $query2);

              $query = " AND daate = '$date' AND city = " . $_SESSION['city'];

              reportShow($query);

?>

        </div>
          <?php

        } else { ?>

          <div style="margin-top: 50px" class="container alert alert-danger">
            <ul>
              <li>عفواً هذا التقرير لم يتم إعداده بعد</li>
            </ul>
          </div>

        <?php
        }

        include $tmp . 'footer.php';

    } else {

      header('Location: ../admin/selectcity.php');

      exite();

    }
  } else {
        header('Location: ../index.php');
    }

  } else {

    header('Location: ../index.php');

    exite();

  }

?>
