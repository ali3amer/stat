<?php
  session_start();

  if((isset($_SESSION['admin']) || isset($_SESSION['mreports'])) && isset($_SESSION['state'])) {

    $nonavbar = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {


      if($_POST['mdaate'] != 0 && $_POST['ydaate'] != 0){

      $date = $_POST['mdaate'] . '-' . $_POST['ydaate'];

      }else {
        header('Location: ../admin/statedate.php');
      }

      include 'init.php';


      $query = "center.state = " . $_SESSION['state'];
      $query2 = " AND daate = '$date'";

      $querydate = " AND daate = '$date' AND state = " . $_SESSION['state'];

      $citys  = checkrow('ID', 'city', "WHERE state = " . $_SESSION['state'] , "", 'ID', '');

      $dates = checkrow('DISTINCT(daate) as daate', 'summ', 'WHERE state = ' . $_SESSION['state'], $query2, 'ID', '');

      


      if($citys != 0 && $dates > 0) {
  ?>


          <div class="report">
            بسم الله الرحمن الرحيم <br />
            الصندوق القومي للتأمين الصحي <br />
            إدارة التخطيط <br />
            قسم الإحصاء <br>
          </div>


          <div class="container reports">

            <?php


            totalReport($date);

            

            duhReport($query, $query2, $querydate);


            centerDetails($query, $query2);


            allCenters($query, $query2);


            pharmacyDetails($query2);

            $query = "AND daate = '$date' AND state = " . $_SESSION['state'];

            reportShow($query);



            pharmacyTotal($query2);










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

      } else {
        header('Location: ../index.php');
    }

        include $tmp . 'footer.php';


  } else {

    header('Location: ../index.php');

    exite();

  }

?>
