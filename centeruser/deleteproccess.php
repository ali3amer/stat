<?php
session_start();
if(isset($_SESSION['centeruser'])) {

    include 'init.php';  

          

    

    $table = (isset($_GET['table']) && is_string($_GET['table'])) ? $_GET['table'] : '';

    $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

    $stmt = $con->prepare("DELETE FROM $table  WHERE ID = ?");

          $stmt->execute(array( $id));

          ?>

        <div class="container text-center alert alert-success">تم الحذف بنجاح</div>

        <?php

        header('refresh: 1; url = ' . $_SESSION['urldir']); 


    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
