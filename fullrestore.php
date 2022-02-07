<form action="" method="post">
    <input type="file" name="report">
    <input type="submit">
</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('G:Backup\\'.$_POST['report']);
    echo '<pre>';
    print_r($summ);
    echo '</pre>';
}

