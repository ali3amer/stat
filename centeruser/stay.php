<?php
session_start();
if(isset($_SESSION['centeruser'])) {

    include 'init.php';

    $visit = (isset($_GET['visit']) && is_numeric($_GET['visit'])) ? intval($_GET['visit']) : 0;

    //$client = (isset($_GET['client']) && is_numeric($_GET['client'])) ? intval($_GET['client']) : 0;

    $client = $_GET['client'];


    $stmt = $con->prepare("UPDATE visit SET
                          stay = ? WHERE ID = ?");

    $stmt->execute(array(1, $visit));

    header('Location: visit.php?do=' . $client);

    include $tmp . 'footer.php';

} else {

    header('Location: ../index.php');
    exite();

}

?>
