<nav class="navbar navbar-inverse ">
 <div class="container">
   <div class="navbar-header">
    <?php
      if(isset($_SESSION['admin']) || isset($_SESSION['superman']) || isset($_SESSION['mreports'])) {
        if(strpos($_SERVER['PHP_SELF'], 'admin') !== false) {
          $home = 'dashboard.php';
        } else {
          $home = 'admin/dashboard.php';
        }

      }elseif (isset($_SESSION['centeruser'])) {
        $home = 'selectcenter.php';
      } else {
        $home = 'userhome.php';
      }
    ?>

     <a class="navbar-brand" href="<?php echo $home; ?>">نظام التقارير الإحصائيه</a>
   </div>

   <?php if(isset($_SESSION['admin']) || isset($_SESSION['superman']) || isset($_SESSION['mreports'])) {
     if(strpos($_SERVER['PHP_SELF'], 'admin') !== false) {
       $logout = '../logout.php';
     } else {
       $logout = 'logout.php';
     }

   } elseif(isset($_SESSION['centeruser'])) {
     $logout = '../logout.php';
   } else {
      $logout = 'logout.php';
    } ?>
   <ul class="nav navbar-nav navbar-right my">
      <li><a style="cursor:pointer;">إسم المستخدم : <?php echo $_SESSION['fullname']; ?></a></li>
      <li><a href="<?php echo $logout; ?>">تسجيل خروج</a></li>

    </ul>

 </div>
</nav>
