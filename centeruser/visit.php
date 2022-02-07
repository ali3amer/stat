<?php
  session_start();
  if(isset($_SESSION['centeruser']) && isset($_SESSION['month'])) {

    if(isset($_SESSION['city'])) {

      include 'init.php';

      $checkmonth = $_SESSION['month'];

      $checkreport = checkrow('ID', 'summ', "WHERE daate = '$checkmonth' ", ' AND center = ' . $_SESSION['center'], 'ID', '');

      if($checkreport == 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nhifid = filter_var($_POST['nhifid'], FILTER_SANITIZE_NUMBER_INT);

        if($nhifid > 0){

          $client = getOne('*', 'client', 'WHERE nhifid = ' . $nhifid, '', 'ID', '');
        } else {
          header("Location: visit.php");
        }
      } elseif(isset($_GET['do'])) {

      //  $nhifid = (isset($_GET['do']) && is_numeric($_GET['do'])) ? intval($_GET['do']) : 0;

        $nhifid = $_GET['do'];

        if($nhifid > 0){


        $client = getOne('*', 'client', 'WHERE nhifid = ' . $nhifid, '', 'ID', '');
        } else {
          header("Location: visit.php");
        }
      }


        if(isset($client)) {

          if($client != null) {

          $daate = date('d-m-Y');

          $month = $_SESSION['month'];

          $visit = checkrow('ID', 'visit', 'WHERE client = ' . $client['ID'] . ' AND center = ' . $_SESSION['center'],  " AND daate = '$daate' ", 'ID', '');
          $stay = checkrow('ID', 'visit', 'WHERE client = ' . $client['ID'] . ' AND stay = 1 ' . ' AND center = ' . $_SESSION['center'] . ' AND stay = 0 ',  " AND vmonth = '$month' ", 'ID', '');

           if($visit == 0 && $stay == 0) {
            $stmt = $con->prepare("INSERT INTO
                                    visit(client, center, vmonth, daate, daay )
                                    VALUES(:client, :center, :vmonth, :daate, :daay) ");

              $stmt->execute(array(

                              'client'      =>  $client['ID'],
                              'center'      =>  $_SESSION['center'],
                              'vmonth'      =>  $month,
                              'daate'       =>  $daate,
                              'daay'        =>  $_SESSION['day']

                      ));
          }

            $visitid = getOne('ID, client, stay', 'visit', 'WHERE client = ' . $client['ID'] . ' AND center = ' . $_SESSION['center'],  " AND daate = '$daate' ", 'ID', '');

          $clientvisit = getOne('ID, nhifid', 'client', 'WHERE ID = ' . $visitid['client'], '', 'ID', '');


            $sector = getOne('name', 'tables', 'WHERE ID = ' . $client['sector'], '', 'ID', '');
            $age = getOne('name', 'tables', 'WHERE ID = ' . $client['age'], '', 'ID', '');
            $card = getOne('name', 'tables', 'WHERE ID = ' . $client['cardstate'], '', 'ID', '');

            $gender    = array('1' => 'ذكر', '2' => 'انثى');

            $adjective = array('1' => 'مؤمن','2' => 'معال');

          }

        }

      $checks = getAllFrom('*', 'tables', 'WHERE tnum = 10', '', 'ID', '');
      $ills = getAllFrom('*', 'tables', 'WHERE tnum = 5', '', 'ID', '');
      $proccess = getAllFrom('*', 'tables', 'WHERE tnum = 9', '', 'ID', '');
      $meets = getAllFrom('*', 'tables', 'WHERE tnum = 7', '', 'ID', '');
      $eyes = getAllFrom('*', 'tables', 'WHERE tnum = 3', '', 'ID', '');
      $defrents = getAllFrom('*', 'tables', 'WHERE tnum = 4', '', 'ID', '');
      $sugers = getAllFrom('*', 'tables', 'WHERE tnum = 6', '', 'ID', '');
      $profs = getAllFrom('*', 'tables', 'WHERE tnum = 12', '', 'ID', '');

      ?>


      <div class="container">
        <div class="row">
          <form class="admin form-horizontal" action="visit.php" method="post">
            <div class="form-group form-group-md">
              <label class="col-md-1 col-md-push-2 control-label">رقم التأمين :</label>
              <div class="col-md-5 col-md-push-2">
                <input class="form-control" type="text" maxlength=11 minlength=11 name="nhifid" autocomplete="off" required  />
              </div>
              <div class="col-md-1 col-md-push-2">
                <input class="form-control btn btn-primary" type="submit" value="بحث" />
              </div>
            </div>
          </form>

          <?php

          if(isset($client)) {
            if ($client == null) {
                addClient("client.php?do=insert");
            } else { ?>

            <div class="">
              <div class="panel panel-default">
                <div class="panel-heading">المعلومات الشخصية</div>
                <div class="panel-body">
                  <ul class="client list-unstyled">
                    <li><span class="client-vist">رقم التأمين</span> : <?php echo $client['nhifid']; ?></li>
                      <li><span class="client-vist">الإسم</span> : <?php echo $client['name']; ?></li>
                    <li><span class="client-vist">النوع</span> : <?php echo $gender[$client['gender']]; ?></li>
                    <li><span class="client-vist">المخدم</span> : <?php echo $client['server']; ?></li>
                    <li><span class="client-vist">القطاع</span> : <?php echo $sector['name']; ?></li>
                    <li><span class="client-vist">الصفه</span> : <?php echo $adjective[$client['adjective']]; ?></li>
                    <li><span class="client-vist">الفئه العمريه</span> : <?php echo $age['name']; ?></li>
                    <li><span class="client-vist">ولاية البطاقه</span> : <?php echo $card['name']; ?></li>
                  </ul>
                  <a href="client.php?do=edit&id=<?php echo $client['ID'] ?>" class="btn btn-primary" >تعديل</a>
                  <a href="show.php?id=<?php echo $client['ID'] ?>&visit=<?php echo $visitid['ID'] ?>" target="_blank" class="btn btn-info" >عرض زيارة اليوم</a>
                  <a href="month.php?id=<?php echo $client['ID'] ?>&daate=<?php echo $_SESSION['month']; ?>" target="_blank" class="btn btn-info" >عرض زيارات الشهر</a>
                    <?php if($visitid['stay'] == 0) { ?>

                        <a href="stay.php?visit=<?php echo $visitid['ID']; ?>&client=<?php echo $nhifid; ?>" class="btn btn-danger" >إقامة</a>


                    <?php } else { ?>

                    <a href="out.php?visit=<?php echo $visitid['ID']; ?>&client=<?php echo $nhifid; ?>" class="btn btn-danger" >مغادرة</a>

                    <?php } ?>
                </div>
              </div>
            </div>

            <div class=" options">



              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">المقابلات</a></li>
                <li><a data-toggle="tab" href="#menu1">الفحوصات</a></li>
                <li><a data-toggle="tab" href="#menu2">الأمراض المزمنه</a></li>
                <li><a data-toggle="tab" href="#menu3">التنويم والعمليات</a></li>
                <li><a data-toggle="tab" href="#menu4">الدواء</a></li>
                <li><a data-toggle="tab" href="#menu5">الأسنان والعيون الوانف والذن</a></li>
                <li><a data-toggle="tab" href="#menu6">التشخييص</a></li>
                <li><a data-toggle="tab" href="#menu7">خدمات السكري</a></li>
                <li><a data-toggle="tab" href="#menu8">الإخصائيين</a></li>
              </ul>

              <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                  <form class="admin form-horizontal" action="proccess.php?do=meet" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($meets as $meet): ?>
                      <div class="visit-check">
                        <div class="col-md-3">
                          <label for="checkbox<?php echo $meet['ID'] ?>">
                            <input class="checkboxclient clientc" id="checkbox<?php echo $meet['ID'] ?>" name="<?php echo $meet['ID'] ?>" type="checkbox" value="<?php echo $meet['ID'] ?>"> <?php echo $meet['name']; ?>
                          </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $meet['ID'] ?>" />
                        </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu1" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=check" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($checks as $check): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $check['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $check['ID'] ?>" name="<?php echo $check['ID'] ?>" type="checkbox" value="<?php echo $check['ID'] ?>"> <?php echo $check['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $check['ID'] ?>" />
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu2" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=ill" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($ills as $ill): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $ill['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $ill['ID'] ?>" name="<?php echo $ill['ID'] ?>" type="checkbox" value="<?php echo $ill['ID'] ?>"> <?php echo $ill['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $ill['ID'] ?>" />
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu3" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=proccess" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($proccess as $procce): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $procce['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $procce['ID'] ?>" name="<?php echo $procce['ID'] ?>" type="checkbox" value="<?php echo $procce['ID'] ?>"> <?php echo $procce['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $procce['ID'] ?>" />
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu4" class="tab-pane fade">
                  <div class="row">
                    <form class="admin form-horizontal" action="proccess.php?do=medcin" method="post">
                      <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                      <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                      <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="تكلفة الدواء 75%" name="cost" />
                      </div>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </form>
                  </div>
                </div>

                <div id="menu5" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=eyes" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($eyes as $eye): 
                        
                      if($eye['name'] == 'الاسنان') {

                        $eyesserv = array(
                          '1' => 'خلع',
                          '2' => 'حشوه',
                          '3' => 'نظافه',
                          '4' => 'أخرى'
                        );

                      }elseif($eye['name'] == 'العيون') {

                        $eyesserv = array(
                          '1' => 'مقابله',
                          '2' => 'كشف نظر',
                          '3' => 'علاج',
                          '4' => 'عمليات',
                          '5' =>  'اخرى'
                        );

                      }elseif($eye['name'] == 'الأنف والأذن والحنجره') {


                        $eyesserv = array(
                          '1' => 'نظافه',
                          '2' => 'غسيل',
                          '3' => 'اخرى'
                        );

                      }  
                        
                        
                      ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $eye['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $eye['ID'] ?>" name="<?php echo $eye['ID'] ?>" type="checkbox" value="<?php echo $eye['ID'] ?>"> <?php echo $eye['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفة المقابله" name="cost_<?php echo $eye['ID'] ?>" />
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="تكلفة الخدمات" name="servcost_<?php echo $eye['ID'] ?>" />
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="تكلفة العمليات" name="jobcost_<?php echo $eye['ID'] ?>" />
                      </div>


                      <div class="col-md-2">
                          <select class="form-control" name="eye_<?php echo $eye['ID']; ?>">
                            <option value="0">إختر ...</option>
                            <?php for($i = 1; $i <= count($eyesserv); $i++ ): ?>

                            <option value="<?php echo $i ?>"><?php echo $eyesserv[$i] ?></option>

                            <?php endfor; ?>
                          </select>
                      </div>




                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu6" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=defrents" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($defrents as $defrent): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $defrent['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $defrent['ID'] ?>" name="<?php echo $defrent['ID'] ?>" type="checkbox" value="<?php echo $defrent['ID'] ?>"> <?php echo $defrent['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="إسم المرض" name="cost_<?php echo $defrent['ID'] ?>" />
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu7" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=suger" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($sugers as $suger): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $suger['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $suger['ID'] ?>" name="<?php echo $suger['ID'] ?>" type="checkbox" value="<?php echo $suger['ID'] ?>"> <?php echo $suger['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $suger['ID'] ?>" />
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>

                <div id="menu8" class="tab-pane fade">
                  <form class="admin form-horizontal" action="proccess.php?do=prof" method="post">
                    <input type="hidden" name="visit" value="<?php echo $visitid['ID']; ?>">
                    <input type="hidden" name="client" value="<?php echo $clientvisit['nhifid']; ?>">
                    <div class="row">
                      <?php foreach($profs as $prof): ?>
                      <div class="visit-check">
                      <div class="col-md-3">
                        <label for="checkbox<?php echo $prof['ID'] ?>">
                          <input class="checkboxclient clientc" id="checkbox<?php echo $prof['ID'] ?>" name="<?php echo $prof['ID'] ?>" type="checkbox" value="<?php echo $prof['ID'] ?>"> <?php echo $prof['name']; ?>
                        </label>
                      </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" placeholder="التكلفه" name="cost_<?php echo $prof['ID'] ?>" />
                      </div>
                      <?php $profsname = getAllFrom('ID, name', 'profsname', 'WHERE prof = ' . $prof['ID'], '', 'ID', ''); ?>
                      <div class="col-md-2">
                          <select class="form-control" name="prof_<?php echo $prof['ID']; ?>">
                            <option value="0">إختر ...</option>
                            <?php foreach($profsname as $profname): ?>

                            <option value="<?php echo $profname['ID'] ?>"><?php echo $profname['name'] ?></option>

                            <?php endforeach; ?>
                          </select>
                      </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="col-md-2">
                        <input class="form-control btn btn-primary" type="submit" value="حفظ" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>




            </div>


            <?php
            }
          }

          ?>

        </div>
      </div>




  <?php
    include $tmp . 'footer.php';

    } else { ?>


          <div class="container alert alert-info text-center">عفواً تم إرسال التقرير لهذا الشهر</div>

       <?php
          header("refresh: 3; url = dashboard.php");
      }

  } else {

    header('Location: ../index.php');
    exite();

  }

} else {

  header('Location: ../index.php');
  exite();

}

?>
