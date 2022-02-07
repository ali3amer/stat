<?php

  include 'connect.php';

  $tmp = 'includes/template/';

  $func = 'includes/functions/';

  $css = 'layout/css/';

  $js = 'layout/js/';

  include $func . 'functions.php';

  include $tmp . 'header.php';


  if(!isset($nonavbar)) { include $tmp . 'navbar.php'; }

?>
