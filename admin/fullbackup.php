<?php

session_start();

include 'init.php';

if(isset($_SESSION['admin'])){

/*
**
*****************************SUMM***********
**
*/

$summs = getAllFrom('*', 'summ', "WHERE state = " . $_SESSION['state'], '', 'ID', '');

if(!file_exists("G:backup/report_".date('d-m-Y').".php")){

$myfile = fopen("G:backup/report_".date('d-m-Y').".php", "x+") or die("Unable to open file!");

$txt = "<?php\n";

fwrite($myfile, $txt);

if($summs != null){


$txt = "$" . "summ = [\n";
fwrite($myfile, $txt);

foreach($summs as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq'] . ",\n" . "'cost'" . " => " . $summ['cost'] . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'day'" . " => " . $summ['day'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate']. "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}

/*
**
*****************************SUMMt***********
**
*/

$summst = getAllFrom('*', 'summt',"WHERE state = " . $_SESSION['state'], '', 'ID', '');

if($summst != null){

$txt = "$" . "summt = [\n";
fwrite($myfile, $txt);

foreach($summst as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq'] . ",\n" . "'cost'" . " => " . $summ['cost'] . ",\n" . "'servcost'" . " => " . $summ['servcost'] . ",\n" . "'jobcost'" . " => " . $summ['jobcost'] . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" ."'day'" . " => " . $summ['day'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate'] . "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}

/*
**
*****************************SUMMP***********
**
*/

$summsp = getAllFrom('*', 'summt',"WHERE state = " . $_SESSION['state'], '', 'ID', '');

if($summsp != null){

$txt = "$" . "summt = [\n";
fwrite($myfile, $txt);

foreach($summsp as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq'] . ",\n" . "'cost'" . " => " . $summ['cost'] . ",\n" . "'servcost'" . " => " . $summ['servcost'] .",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'day'" . " => " . $summ['day'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate'] . "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}


/*
**
*****************************FREQ***********
**
*/

$freqs = getAllFrom('*', 'freq',"WHERE state = " . $_SESSION['state'], '', 'ID', '');

if($freqs != null){

$txt = "$" . "freqs = [\n";
fwrite($myfile, $txt);

foreach($freqs as $summ){

    $txt = "[\n" . "'tnum'" . " => " . $summ['tnum'] . ",\n" . "'nameid'" . " => " . $summ['nameid'] . ",\n" . "'freq'" . " => " . $summ['freq']  . ",\n" . "'state'" . " => " . $summ['state'] . ",\n" . "'city'" . " => " . $summ['city'] . ",\n" . "'center'" . " => " . $summ['center'] . ",\n" . "'day'" . " => " . $summ['day'] . ",\n" . "'daate'" . " => " . "'" . $summ['daate'] . "'" . "],\n";
    fwrite($myfile, $txt);

}
$txt = "];\n";

fwrite($myfile, $txt);

}


$txt = "?>\n";
fwrite($myfile, $txt);
fclose($myfile);

?>

<div class="container alert alert-success text-center">تم حفظ الملف بنجاح</div>

<?php

header("refresh: 3; url = admin/dashboard.php");
}else{

?>

<div class="container alert alert-danger text-center">هذا الملف موجود بالفعل</div>

<?php   
}

} else{ 
    header('Location: index.php');

}