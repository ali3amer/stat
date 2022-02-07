<?php

session_start();

include 'init.php';

if(isset($_SESSION['admin'])){

if($_SERVER['REQUEST_METHOD'] == 'POST') {

if(file_exists('G:\Backup\report_' . $_POST['mdaate'] . '-' . $_POST['ydaate'] . '.php')){


include 'D:\Backup\report_' . $_POST['mdaate'] . '-' . $_POST['ydaate'] . '.php';



if(isset($summ) && isset($summt) && isset($freqs)) {
    $i = 0;
    foreach($summ as $sum) {

        $check = checkrow('ID', 'summ', 'WHERE state = ' . $sum['state'], ' AND city = ' . $sum['city'] . ' AND center = ' . $sum['center'] . ' AND daate = ' . "'" . $sum['daate'] . "'", 'ID', '');
        
        if($check == 0) {

            $stmt = $con->prepare("INSERT INTO
                                summ(tnum, nameid, freq, cost, state, city, center, daate)
                                VALUES(:tnum, :nameid, :freq, :cost, :state, :city, :center, :daate) ");


            $stmt->execute(array(

                            'tnum'      =>  $sum['tnum'],
                            'nameid'    =>  $sum['nameid'],
                            'freq'      =>  $sum['freq'],
                            'cost'      =>  $sum['cost'],
                            'state'     =>  $sum['state'],
                            'city'      =>  $sum['city'],
                            'center'    =>  $sum['center'],
                            'daate'     =>  $sum['daate']

                    ));

            $inserted = $stmt->rowCount();

            $i++;

        }


    }







    $j = 0;
    foreach($summt as $sum) {

        $check = checkrow('ID', 'summt', 'WHERE state = ' . $sum['state'], ' AND city = ' . $sum['city'] . ' AND center = ' . $sum['center'] . ' AND daate = ' . "'" . $sum['daate'] . "'", 'ID', '');
        
        if($check == 0) {

            $stmt = $con->prepare("INSERT INTO
                                summt(tnum, nameid, freq, cost, servcost, jobcost, state, city, center, daate)
                                VALUES(:tnum, :nameid, :freq, :cost, :servcost, :job, :state, :city, :center, :daate) ");


            $stmt->execute(array(

                            'tnum'      =>  $sum['tnum'],
                            'nameid'    =>  $sum['nameid'],
                            'freq'      =>  $sum['freq'],
                            'cost'      =>  $sum['cost'],
                            'servcost'  =>  $sum['servcost'],
                            'job'       =>  $sum['jobcost'],
                            'state'     =>  $sum['state'],
                            'city'      =>  $sum['city'],
                            'center'    =>  $sum['center'],
                            'daate'     =>  $sum['daate']

                    ));

            $inserted = $stmt->rowCount();

            $j++;

        }


    }






    $f = 0;
    foreach($freqs as $sum) {

        $check = checkrow('ID', 'freq', 'WHERE state = ' . $sum['state'], ' AND city = ' . $sum['city'] . ' AND center = ' . $sum['center'] . ' AND daate = ' . "'" . $sum['daate'] . "'", 'ID', '');
        
        if($check == 0) {

            $stmt = $con->prepare("INSERT INTO
                                freq(tnum, nameid, freq, state, city, center, daate)
                                VALUES(:tnum, :nameid, :freq, :state, :city, :center, :daate) ");


            $stmt->execute(array(

                            'tnum'      =>  $sum['tnum'],
                            'nameid'    =>  $sum['nameid'],
                            'freq'      =>  $sum['freq'],
                            'state'     =>  $sum['state'],
                            'city'      =>  $sum['city'],
                            'center'    =>  $sum['center'],
                            'daate'     =>  $sum['daate']

                    ));

            $inserted = $stmt->rowCount();

            $f++;

        }


    }


if($j != 0 || $i != 0 || $f != 0) {
?>

    <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

<?php 
} else {
?>

    <div class="container text-center alert alert-info">هذه البيانات موجوده مسيقاً</div>

<?php     
}
} else {
?>

    <div class="container text-center alert alert-danger">هذا الملف غير موجود</div>

<?php    
}



  }


}else{
 ?>

    <div class="container">
          <form class="form-horizontal" action="restore.php" method="post">
            <div class="row">
              <div class="form-group form-group-md">
                <label class="col-md-3 control-label">حدد التاريخ</label>
                <div class="col-md-3">
                  <select class="form-control" name="mdaate">
                    <option value="0">إختر ...</option>
                    <?php for($i = 1; $i <= 12;$i++):
                      if($i < 10) {
                        $date = '0' . $i;
                      } else {
                        $date = $i;
                      }
                    ?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="ydaate">
                    <option value="0">إختر ...</option>
                    <?php for($i = 2018; $i <= 2025;$i++):
                       $date = $i;?>
                      <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                    <?php endfor; ?>

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
}

} else{ 
    header('Location: ../index.php');

}



?>