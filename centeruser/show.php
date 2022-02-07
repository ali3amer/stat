<?php
  session_start();
  if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

      include 'init.php';

      $_SESSION['urldir'] = $_SERVER['REQUEST_URI'];

      $visitid = (isset($_GET['visit']) && is_numeric($_GET['visit'])) ? intval($_GET['visit']) : 0;

      $nhifid = isset($_GET['id']) ? $_GET['id'] : 0;

      $client = getOne('*', 'client', 'WHERE ID = ' . $nhifid, '', 'ID', '');

      if($client != null) {

        $sector = getOne('name', 'tables', 'WHERE ID = ' . $client['sector'], '', 'ID', '');
        $age = getOne('name', 'tables', 'WHERE ID = ' . $client['age'], '', 'ID', '');
        $card = getOne('name', 'tables', 'WHERE ID = ' . $client['cardstate'], '', 'ID', '');

        $gender    = array('1' => 'ذكر', '2' => 'انثى');

        $adjective = array('1' => 'مؤمن','2' => 'معال');

      ?>

      <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">معلومات شخصية</div>
          <div class="panel-body">
            <ul class="client list-unstyled">
              <li><span class="client-vist">الإسم</span> : <?php echo $client['name']; ?></li>
              <li><span class="client-vist">رقم التأمين</span> : <?php echo $client['nhifid']; ?></li>
              <li><span class="client-vist">النوع</span> : <?php echo $gender[$client['gender']]; ?></li>
              <li><span class="client-vist">المخدم</span> : <?php echo $client['server']; ?></li>
              <li><span class="client-vist">القطاع</span> : <?php echo $sector['name']; ?></li>
              <li><span class="client-vist">الصفه</span> : <?php echo $adjective[$client['adjective']]; ?></li>
              <li><span class="client-vist">الفئه العمريه</span> : <?php echo $age['name']; ?></li>
              <li><span class="client-vist">ولاية البطاقه</span> : <?php echo $card['name']; ?></li>
            </ul>
            <a href="client.php?do=edit&id=<?php echo $client['ID'] ?>" class="btn btn-primary" >تعديل</a>
          </div>
        </div>


        <?php
        $meets  = getAllFrom('meet.*, tables.name as name', 'meet', 'INNER JOIN tables ON tables.ID = meet.meet WHERE visit = ' . $visitid, '', 'ID', '');
        $checks = getAllFrom('checks.*, tables.name as name', 'checks', 'INNER JOIN tables ON tables.ID = checks.checks WHERE visit = ' . $visitid, '', 'ID', '');
        $ills  = getAllFrom('ills.*, tables.name as name', 'ills', 'INNER JOIN tables ON tables.ID = ills.ill WHERE visit = ' . $visitid, '', 'ID', '');
        $proccess = getAllFrom('proccess.*, tables.name as name', 'proccess', 'INNER JOIN tables ON tables.ID = proccess.procces WHERE visit = ' . $visitid, '', 'ID', '');
        $eyes  = getAllFrom('eyes.*, tables.name as name', 'eyes', 'INNER JOIN tables ON tables.ID = eyes.eye WHERE visit = ' . $visitid, '', 'ID', '');
        $defrents  = getAllFrom('defrent.*, tables.name as name', 'defrent', 'INNER JOIN tables ON tables.ID = defrent.defrent WHERE visit = ' . $visitid, '', 'ID', '');
        $profs  = getAllFrom('prof.*, tables.name as name, profsname.name as profname', 'prof', 'INNER JOIN tables ON tables.ID = prof.prof INNER JOIN profsname ON profsname.ID = prof.profname WHERE visit = ' . $visitid, '', 'prof.ID', '');
        $sugers  = getAllFrom('suger.*, tables.name as name', 'suger', 'INNER JOIN tables ON tables.ID = suger.suger WHERE visit = ' . $visitid, '', 'ID', '');
        $medcins  = getAllFrom('*', 'medcin', 'WHERE visit = ' . $visitid, '', 'ID', '');

        $summ = 0;

        if($meets != null) { ?>
          <div class="panel panel-default">
            <div class="panel-heading">المقابلات</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered">

                  <tr>
                    <th>التاريخ</th>
                    <th>الطبيب</th>
                    <th>التكلفه</th>
                    <th>التحكم</th>
                  </tr>
                  <?php $cost = 0; foreach($meets as $meet): ?>

                    <tr>
                      <td><?php echo $meet['daate']; ?></td>
                      <td><?php echo $meet['name']; ?></td>
                      <td><?php $cost += $meet['cost']; echo $meet['cost']; ?></td>
                      <td>
                        <a class="btn btn-info" href="updateproccess.php?table=meet&tnum=7&id=<?php echo $meet['ID'] ?>">تعديل</a> 
                        <a class="btn btn-danger confirm" href="deleteproccess.php?table=meet&id=<?php echo $meet['ID'] ?>">حذف</a>
                      </td>
                    </tr>

                  <?php endforeach; ?>

                  <tr>
                    <th colspan="2">الجمله</th>
                    <th><?php $summ += $cost; echo $cost; ?></th>
                    <th></th>
                  </tr>
                </table>
              </div>
            </div>

          </div>

        <?php
          }

      if($checks != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">الفحوصات</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>الفحص</th>
                  <th>التكلفه</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($checks as $check): ?>

                  <tr>
                    <td><?php echo $check['daate']; ?></td>
                    <td><?php echo $check['name']; ?></td>
                    <td><?php $cost += $check['cost']; echo $check['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=checks&tnum=10&id=<?php echo $check['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=checks&id=<?php echo $check['ID'] ?>">حذف</a>
                     </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="2">الجمله</th>
                  <th><?php $summ += $cost; echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($ills != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">الأمراض المزمنه</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>المرض</th>
                  <th>التكلفه</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($ills as $ill): ?>

                  <tr>
                    <td><?php echo $ill['daate']; ?></td>
                    <td><?php echo $ill['name']; ?></td>
                    <td><?php $cost += $ill['cost']; echo $ill['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=ills&tnum=5&id=<?php echo $ill['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=ills&id=<?php echo $ill['ID'] ?>">حذف</a> 
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="2">الجمله</th>
                  <th><?php echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($proccess != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">العمليات</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>العملية</th>
                  <th>التكلفه</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($proccess as $procces): ?>

                  <tr>
                    <td><?php echo $procces['daate']; ?></td>
                    <td><?php echo $procces['name']; ?></td>
                    <td><?php $cost += $procces['cost']; echo $procces['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=proccess&tnum=9&id=<?php echo $procces['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=proccess&id=<?php echo $procces['ID'] ?>">حذف</a>
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="2">الجمله</th>
                  <th><?php $summ += $cost; echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($eyes != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">العيون والأنف والأذن والحنجره</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>الاسم</th>
                  <th>التكلفة المقابله</th>
                  <th>تكلفة الخدمات</th>
                  <th>تكلفة العمليات</th>
                  <th>التكلفة الكلية</th>
                  <th>التحكم</th>
                </tr>
                <?php

                $cost = 0; $servcost = 0; $jobcos = 0; $allcost = 0;

                 foreach($eyes as $eye): ?>

                  <tr>
                    <td><?php echo $eye['daate']; ?></td>
                    <td><?php echo $eye['name']; ?></td>
                    <td><?php $allcost += $cost     += $eye['cost']; echo $eye['cost']; ?></td>
                    <td><?php $allcost += $servcost += $eye['servcost']; echo $eye['servcost']; ?></td>
                    <td><?php $allcost += $jobcos   += $eye['jobcost']; echo $eye['jobcost']; ?></td>
                    <td><?php echo ($cost + $servcost + $jobcos); ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=eyes&tnum=3&id=<?php echo $eye['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=eyes&id=<?php echo $eye['ID'] ?>">حذف</a>
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="2">الجمله</th>
                  <th><?php echo $cost; ?></th>
                  <th><?php echo $servcost; ?></th>
                  <th><?php echo $jobcos; ?></th>
                  <th><?php $summ += $allcost; echo $allcost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($defrents != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">التشخييص</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>التشخييص</th>
                  <th>إسم المرض</th>
                  <th>التحكم</th>
                </tr>
                <?php foreach($defrents as $defrent): ?>

                  <tr>
                    <td><?php echo $defrent['daate']; ?></td>
                    <td><?php echo $defrent['name']; ?></td>
                    <td><?php echo $defrent['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=defrent&tnum=4&id=<?php echo $defrent['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=defrent&id=<?php echo $defrent['ID'] ?>">حذف</a>                    
                    </td>
                  </tr>

                <?php endforeach; ?>

              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($sugers != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">خدمات السكري</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>الخدمه</th>
                  <th>التكلفه</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($sugers as $suger): ?>

                  <tr>
                    <td><?php echo $suger['daate']; ?></td>
                    <td><?php echo $suger['name']; ?></td>
                    <td><?php $cost += $suger['cost']; echo $suger['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=suger&tnum=6&id=<?php echo $suger['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=suger&id=<?php echo $suger['ID'] ?>">حذف</a>
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="2">الجمله</th>
                  <th><?php $summ += $cost; echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($profs != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">الإختصاصيين</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>إسم الاخصائي</th>
                  <th>الأخصائي</th>
                  <th>التكلفه</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($profs as $prof): ?>

                  <tr>
                    <td><?php echo $prof['daate']; ?></td>
                    <td><?php echo $prof['profname']; ?></td>
                    <td><?php echo $prof['name']; ?></td>
                    <td><?php $cost += $prof['cost']; echo $prof['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=prof&tnum=12&id=<?php echo $prof['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=prof&id=<?php echo $prof['ID'] ?>">حذف</a>
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th colspan="3">الجمله</th>
                  <th><?php $summ += $cost; echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
      }

      if($medcins != null) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">الدواء</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered">

                <tr>
                  <th>التاريخ</th>
                  <th>التكلفة</th>
                  <th>التحكم</th>
                </tr>
                <?php $cost = 0; foreach($medcins as $medcin): ?>

                  <tr>
                    <td><?php echo $medcin['daate']; ?></td>
                    <td><?php $cost += $medcin['cost']; echo $medcin['cost']; ?></td>
                    <td>
                     <a class="btn btn-info" href="updateproccess.php?table=medcin&id=<?php echo $medcin['ID'] ?>">تعديل</a> 
                     <a class="btn btn-danger confirm" href="deleteproccess.php?table=medcin&id=<?php echo $medcin['ID'] ?>">حذف</a>
                    </td>
                  </tr>

                <?php endforeach; ?>

                <tr>
                  <th>الجمله</th>
                  <th><?php $summ += $cost; echo $cost; ?></th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>

        </div>


      <?php
    } ?>

      <div class="panel panel-default">
          <div class="panel-heading">الجمـــله</div>
          <div class="panel-body">
              <div class="table-responsive">
                  <table class="table table-bordered">

                      <tr>
                          <th>الجملة</th>
                          <th><?php echo $summ; ?></th>
                      </tr>

                  </table>
              </div>
          </div>

      </div>

  </div>
    <?php

    }

    include $tmp . 'footer.php';

} else {

  header('Location: ../index.php');
  exite();

}

?>
