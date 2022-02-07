<?php
function getTitle() {

  global $pageTitle;

  if(isset($pageTitle)) {

    echo $pageTitle;

  } else {

    echo "نظام التقارير الإحصائية";

  }

}

function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

	global $con;

	$stmt = $con->prepare("SELECT $field from $table $where $and ORDER BY $orderfield $ordering");
	$stmt->execute();
	$all = $stmt->fetchAll();

	return $all;

}

function getOne($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

	global $con;

	$stmt = $con->prepare("SELECT $field from $table $where $and ORDER BY $orderfield $ordering");
	$stmt->execute();
	$all = $stmt->fetch();

	return $all;

}

function checkrow($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

	global $con;

	$stmt = $con->prepare("SELECT $field from $table $where $and ORDER BY $orderfield $ordering");
	$stmt->execute();
	$all = $stmt->rowCount();

	return $all;

}



function addClient($url) {

  $sectors  = getAllFrom('*', 'tables', 'WHERE tnum = 2', '', 'ID', '');
  $ages     = getAllFrom('*', 'tables', 'WHERE tnum = 1', '', 'ID', '');
  $states   = getAllFrom('*', 'tables', 'WHERE tnum = 11', '', 'ID', '');
  ?>

    <form class="admin form-horizontal" action="<?php echo $url; ?>" method="post">
      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">رقم التأمين :</label>
        <div class="col-md-6">
          <input class="form-control" maxlength=11 minlength=11 type="text" name="nhifid" autocomplete="off" required />
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">الإسم :</label>
        <div class="col-md-6">
          <input class="form-control" type="text" name="name" autocomplete="off" required  />
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">الجنس :</label>
        <div class="col-md-6">
          <select class="form-control" name="gender">
            <option value="0">إختر...</option>
            <option value="1">ذكر</option>
            <option value="2">انثى</option>
          </select>
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">المخدم :</label>
        <div class="col-md-6">
          <input class="form-control" type="text" name="server" autocomplete="off" required  />
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">القطاع :</label>
        <div class="col-md-6">
          <select class="form-control" name="sector">
            <option value="0">إختر...</option>
            <?php foreach($sectors as $sector): ?>
            <option value="<?php echo $sector['ID'] ?>"><?php echo $sector['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">الصفه :</label>
        <div class="col-md-6">
          <select class="form-control" name="adjective">
            <option value="0">إختر...</option>
            <option value="1">مؤمن</option>
            <option value="2">معال</option>
          </select>
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">العمر :</label>
        <div class="col-md-6">
          <select class="form-control" name="age">
            <option value="0">إختر...</option>
            <?php foreach($ages as $age): ?>
            <option value="<?php echo $age['ID'] ?>"><?php echo $age['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group form-group-md">
        <label class="col-md-3 control-label">ولاية البطاقه :</label>
        <div class="col-md-6">
          <select class="form-control" name="cardstate">
            <option value="0">إختر...</option>
            <?php foreach($states as $state): ?>
            <option value="<?php echo $state['ID'] ?>" <?php if($state['name'] == $_SESSION['statename']) { echo 'selected'; } ?>><?php echo $state['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group form-group-md">
        <div class="col-md-offset-3 col-md-6">
          <input class="btn btn-primary btn-lg" type="submit" name="" value="حــفـــظ">
        </div>
      </div>

    </form>


<?php
}


function insertData($tnum, $nameid, $freq, $cost, $date) {
  global $con;
  $stmt = $con->prepare("INSERT INTO
                        summ(tnum, nameid, freq, cost, state, city, center, daate)
                        VALUES(:tnum,:nameid, :freq, :cost, :state, :city, :center, :d) ");


  $stmt->execute(array(

                  'tnum'      =>  $tnum,
                  'nameid'    =>  $nameid,
                  'freq'      =>  $freq,
                  'cost'      =>  $cost,
                  'state'     =>  $_SESSION['state'],
                  'city'      =>  $_SESSION['city'],
                  'center'    =>  $_SESSION['center'],
                  'd'         =>  $date

          ));
}



function insertSummt($tnum, $nameid, $freq, $cost, $servcost, $jobcost, $date) {

  global $con;

  $stmt = $con->prepare("INSERT INTO
                        summt(tnum, nameid, freq, cost, servcost, jobcost, state, city, center, daate)
                        VALUES(:tnum, :nameid, :freq, :cost, :servcost, :job, :state, :city, :center, :d) ");


  $stmt->execute(array(

                  'tnum'      =>  $tnum,
                  'nameid'    =>  $nameid,
                  'freq'      =>  $freq,
                  'cost'      =>  $cost,
                  'servcost'  =>  $servcost,
                  'job'       =>  $jobcost,
                  'state'     =>  $_SESSION['state'],
                  'city'      =>  $_SESSION['city'],
                  'center'    =>  $_SESSION['center'],
                  'd'         =>  $date

          ));
}


function insertFreq($tnum, $nameid, $freq, $date) {
  global $con;

  $stmt = $con->prepare("INSERT INTO
                        freq(tnum, nameid, freq, state, city, center, daate)
                        VALUES(:tnum,:nameid, :freq, :state, :city, :center, :d) ");


  $stmt->execute(array(

                  'tnum'      =>  $tnum,
                  'nameid'    =>  $nameid,
                  'freq'      =>  $freq,
                  'state'     =>  $_SESSION['state'],
                  'city'      =>  $_SESSION['city'],
                  'center'    =>  $_SESSION['center'],
                  'd'         =>  $date

          ));

}

function reportShow($query) {




    $arrayTable = array(

      '1'   => '1/التردد حسب الفئات العمريه',
      '2'   =>  '2/التردد والتكلفه حسب القطاعات',
      '3'   =>  '3/التردد والتكلفه لخدمات الاسنان والانف والاذن والحنجره',
      '4'   =>  '4/التردد والتكلفه حسب الامراض المختلفه',
      '5'   =>  '5/التردد والتكلفه حسب الامراض المزمنه',
      '6'   =>  '6/خدمات خاصه بمرضى السكري',
      '7'   =>  '7/التردد والتكلفه حسب المستوى الاول',
      '8'   =>  '8/التردد والتكلفه والاحاله للاختصاصيين',
      '9'   =>  '9/التردد على العمليات والخدمات السريريه والتقويم',
      '10'  =>  '10/التردد على الفحوصات المعمليه والتشخيصيه',
      '11'  =>  '11/التردد للبطاقه القوميه حسب الولايات',
      '12'  =>  '12/تفاصيل الاحاله على خدمات الاختصاصيين',
      '13'  =>  '13/الترددوجملة تردد الدواء والامراض المزمنه',
      '14'  =>  '14/تفاصيل الإحالة على خدمة الإختصاصيين خارج الولاية',
      '15'  =>  '15/تفاصيل الاحاله على خدمة الاختصاصيين داخل المحليه',
      '16'  =>  '16/تفاصيل الفحوصات المعمليه بالعينات',
      '17'  =>  '17/تردد قوات الشرطه واسرهم على منافذ الخدمه'

    );

    for ($j = 1; $j <= 17; $j++) {

        if($j == 3) {

            $rows = getAllFrom('*', 'summt', ' WHERE tnum = ' . $j, $query, 'ID', '');

        }elseif($j == 4 || $j == 13 || $j == 14 || $j == 16) {

            $rows = getAllFrom('*', 'freq', ' WHERE tnum = ' . $j, $query, 'ID', '');

        } elseif($j == 17) {

            $rows = getAllFrom('*', 'summp', ' WHERE tnum = ' . $j, $query, 'ID', '');

        } else {

            $rows = getAllFrom('*', 'summ', ' WHERE tnum = ' . $j, $query, 'ID', '');

        }

        $names = getAllFrom('ID, name', 'tables', 'WHERE tnum = ' . $j, '', 'ID', '');


    if($rows != null) { ?>

        <div class="tables-section breakpage">
            <div class="table-responsive">
                <table class="table table-bordered">

                    <?php

                    if($j == 1){ ?>

                        <tr>
                            <th colspan="<?php echo count($names) + 2; ?>"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th rowspan="2">البيان</th>
                            <th colspan="<?php echo count($names); ?>">الفــــــــــئات العمريه</th>
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            <?php foreach($names as $name): ?>
                                <th>
                                    <?php echo $name['name']; ?>
                                </th>
                            <?php endforeach; ?>


                        </tr>
                        <tr>
                            <th>ذكر</th>
                            <?php $total = 0; foreach($names as $name):?>
                                <td><?php

                                    $value = 0;
                                    foreach($rows as $row):

                                        if($name['ID'] == $row['nameid']) {
                                            $value += $row['freq'];
                                        }
                                    endforeach;
                                    $total += $value; echo $value;

                                    ?></td>
                            <?php endforeach;?>
                            <td><?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <th>إنثى</th>
                            <?php $total = 0; foreach($names as $name):?>
                                <td><?php

                                    $value = 0;
                                    foreach($rows as $row):

                                        if($name['ID'] == $row['nameid']) {
                                            $value += $row['cost'];
                                        }
                                    endforeach;
                                    $total += $value; echo $value;

                                    ?></td>
                            <?php endforeach;?>
                            <td><?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <th>المجموع</th>
                            <?php $total = 0; foreach($names as $name):?>
                                <td><?php
                                    $freq = 0;
                                    $cost = 0;
                                    foreach($rows as $row):

                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                            $cost += $row['cost'];
                                        }
                                    endforeach;


                                    $total += $freq + $cost; echo $freq + $cost; ?></td>
                            <?php endforeach;?>
                            <td><?php echo $total; ?></td>
                        </tr>


                        <?php
                    } elseif($j == 3) { ?>
                        <tr>
                            <th colspan="7"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th>البيان</th>
                            <th>عدد المترددين</th>
                            <th>تكليفة الخدمه المقابله</th>
                            <th>تكلفة الخدمات</th>
                            <th>تكليفة العمليات</th>
                            <th>التكلفة الكليه</th>
                            <th>متوسط التكلفه</th>
                        </tr>
                        <?php
                        $totalf = 0;$totalc = 0;$totals = 0;$totalj = 0;
                        foreach($names as $name):?>
                            <tr>
                                <td>
                                    <?php
                                    $sumfreq = 0;$sumcost = 0;$sumservcost = 0;$sumjobcost = 0;
                                    $freq = 0;$cost = 0;$servcost = 0;$jobcost = 0;

                                    foreach($rows as $row) {

                                        if($row['nameid'] == $name['ID']) {

                                            $freq += $row['freq'];$cost += round($row['cost'], 2);$servcost += round($row['servcost'], 2);$jobcost += round($row['jobcost'], 2);

                                        }

                                    }
                                    echo $name['name'];
                                    ?>
                                </td>
                                <td><?php $totalf += $sumfreq += round($freq, 2); echo round($freq, 2); ?></td>
                                <td><?php $totalc += $sumcost += round($cost, 2); echo round($cost, 2); ?></td>
                                <td><?php $totals += $sumservcost += round($servcost, 2); echo round($servcost, 2); ?></td>
                                <td><?php $totalj += $sumjobcost += round($jobcost, 2); echo round($jobcost, 2); ?></td>
                                <td><?php echo ($sumcost + $sumservcost + $sumjobcost); ?></td>
                                <td><?php if($freq != 0) { echo round(($sumcost + $sumservcost + $sumjobcost) / $freq, 2); } else { echo 0; } ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <th>الجمله</th>
                            <th><?php echo $totalf; ?></th>
                            <th><?php echo $totalc; ?></th>
                            <th><?php echo $totals; ?></th>
                            <th><?php echo $totalj; ?></th>
                            <th><?php echo ($totalc + $totals + $totalj); ?></th>
                            <th><?php if($totalf != 0) { echo round(($totalc + $totals + $totalj) / $totalf, 2); } else { echo 0; } ?></th>
                        </tr>

                        <?php
                    } elseif($j == 4 || $j == 14 || $j == 16) {  ?>

                        <tr>
                            <th colspan="2"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th>المرض</th>
                            <th>التردد</th>
                        </tr>
                        <?php $total = 0; foreach($names as $name):
                            $freq = 0;
                            foreach($rows as $row) {

                                if($name['ID'] == $row['nameid']) {

                                    $freq += $row['freq'];

                                }

                            }

                            $total += $freq; ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $name['name'];
                                    ?>
                                </td>
                                <td><?php echo $freq; ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <th>الجمله</th>
                            <th><?php echo $total; ?></th>
                        </tr>

                        <?php
                    } elseif($j == 5) { ?>

                        <tr>
                            <th colspan="<?php echo count($names) + 2; ?>"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th>المرض</th>
                            <?php foreach($names as $name):?>
                                <th>
                                    <?php echo $name['name']; ?>
                                </th>
                            <?php endforeach;?>
                            <th>المجموع</th>
                        </tr>
                        <tr>
                            <th>التردد</th>
                            <?php $totalfreq = 0; foreach($names as $name):?>
                                <td>
                                    <?php
                                    $freq = 0;
                                    foreach($rows as $row) {
                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                        }
                                    }

                                    $totalfreq += $freq; echo $freq;
                                    ?>
                                </td>
                            <?php endforeach;?>
                            <th><?php echo $totalfreq; $freqill = $totalfreq; ?></th>
                        </tr>
                        <tr>
                            <th>التكلفة</th>
                            <?php $totalcost = 0; foreach($names as $name):?>
                                <td>
                                    <?php
                                    $cost = 0;
                                    foreach($rows as $row) {
                                        if($name['ID'] == $row['nameid']) {
                                            $cost += round($row['cost'], 2);
                                        }
                                    }

                                    $totalcost += $cost; echo $cost;
                                    ?>
                                </td>
                            <?php endforeach;?>
                            <th><?php echo $totalcost; $costill = $totalcost; ?></th>
                        </tr>
                        <tr>
                            <th>متوسط التكلفه</th>
                            <?php $total = 0; foreach($names as $name):?>
                                <td><?php
                                    $freq = 0;
                                    $cost = 0;
                                    foreach($rows as $row):

                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                            $cost += $row['cost'];
                                        }
                                    endforeach;


                                    if($freq != 0) { echo round($cost/$freq, 2); } else { echo 0; } ?></td>
                            <?php endforeach;?>
                            <th><?php

                                if($totalfreq != 0) {
                                    $total = round($totalcost / $totalfreq, 2);
                                } else {
                                    $total = 0;
                                }

                                echo $total;

                                ?></th>
                        </tr>

                        <tr>
                            <th>نسبة التردد من إجمالي <br>تردد الأمراض المزمنه</th>
                            <?php foreach($names as $name):?>
                            <td><?php
                                $freq = 0;
                                foreach($rows as $row):

                                    if($name['ID'] == $row['nameid']) {
                                        $freq += $row['freq'];
                                    }
                                endforeach;


                                if($freqill != 0) { echo round((($freq / $freqill) * 100), 2); } else { echo 0; }?></td>
                            <?php endforeach; ?>
                            <th><?php if($freqill != 0) { echo round((($totalfreq / $freqill) * 100), 2); } else { echo 0; } ?></th>

                        </tr>
                        <tr>
                            <th>نسبة التردد من إجمالي <br>التردد</th>
                            <?php foreach($names as $name):?>
                                <td><?php
                                    $freq = 0;
                                    foreach($rows as $row):

                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                        }
                                    endforeach;


                                    if(isset($frequncy) && $frequncy != 0) { echo round((($freq / $frequncy) * 100), 2); } else { echo 0; }?></td>
                            <?php endforeach; ?>
                            <th><?php if(isset($frequncy) && $frequncy != 0) { echo round((($totalfreq / $frequncy) * 100), 2); } else { echo 0; } ?></th>

                        </tr>

                        <?php
                    } elseif($j == 6) { ?>


                        <tr>
                            <th colspan="4"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th>البيان</th>
                            <th>التردد</th>
                            <th>التكلفه</th>
                            <th>متوسط تكلفة الفرد</th>
                        </tr>
                        <?php foreach($names as $name): ?>
                            <tr>
                                <td>
                                    <?php
                                    $freq = 0;$cost = 0;
                                    foreach($rows as $row) {
                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                            $cost += round($row['cost'], 2);
                                        }
                                    }
                                    echo $name['name'];
                                    ?>
                                </td>
                                <td><?php echo $freq; ?></td>
                                <td><?php echo $cost; ?></td>
                                <td><?php if($freq == 0) {echo 0;} else {echo round(($cost / $freq), 2);} ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php
                    } elseif($j == 13) { ?>

                        <tr>
                            <th colspan="<?php echo count($names) + 4; ?>"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th rowspan="2">التردد الكلي</th>
                            <th rowspan="2">التكلفه الكليه</th>
                            <th colspan="2">الامراض المزمنه</th>
                            <th colspan="2">الدواء</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

                        <tr>
                            <th>التردد</th>
                            <th>التكلفه</th>
                            <?php foreach($names as $name):?>
                                <th>
                                    <?php echo $name['name']; ?>
                                </th>
                            <?php endforeach;?>
                        </tr>
                        <tr>
                            <td><?php if(isset($frequncy)) { echo $frequncy; } ?></td>
                            <td><?php if(isset($allcost)) { echo round($allcost, 2); } ?></td>
                            <td><?php if(isset($freqill)) { echo $freqill; } ?></td>
                            <td><?php if(isset($costill)) { echo round($costill, 2); } ;?></td>
                            <?php foreach($names as $name):?>
                                <td>
                                    <?php
                                    $freq = 0;
                                    foreach($rows as $row) {
                                        if($name['ID'] == $row['nameid']) {
                                            $freq += round($row['freq'], 2);
                                        }
                                    }

                                    echo $freq;
                                    ?>
                                </td>
                            <?php endforeach;?>
                        </tr>


                        <?php

    }elseif($j == 17) { ?>

    <tr>
      <th colspan="5"><?php echo $arrayTable[$j]; ?></th>
    </tr>

      <tr>
        <th>البيان</th>
        <th>التردد</th>
        <th>الخدمات</th>
        <th>التكلفه</th>
        <th>متوسط التكلفة</th>
      </tr>

    <?php
        $totalf = 0;$totalc = 0;$totals = 0;
        foreach($names as $name):?>
            <tr>
                <td>
                    <?php
                    $sumfreq = 0;$sumcost = 0;$sumservcost = 0;
                    $freq = 0;$cost = 0;$servcost = 0; $avg = 0;

                    foreach($rows as $row) {

                        if($row['nameid'] == $name['ID']) {

                            $freq += $row['freq'];$cost += round($row['cost'], 2);$servcost += round($row['servcost'], 2);

                        }

                    }
                    echo $name['name'];
                    ?>
                </td>
                
                <td><?php $totalf += $sumfreq += round($freq, 2); echo round($freq, 2); ?></td>
                <td><?php $totals += $sumservcost += round($servcost, 2); echo round($servcost, 2); ?></td>
                <td><?php $totalc += $sumcost += round($cost, 2); echo round($cost, 2); ?></td>
                <td><?php if($sumfreq != 0){  $avg = $cost/$freq; echo $avg; } else { echo $avg = 0; } ?></td>
            </tr>
        <?php endforeach; ?>

    <?php
    } else { ?>

                        <tr>
                            <th colspan="4"><?php echo $arrayTable[$j]; ?></th>
                        </tr>
                        <tr>
                            <th>البيان</th>
                            <th>التردد</th>
                            <th>التكلفه</th>
                            <th>متوسط التكلفة</th>
                        </tr>
                        <?php $summfreq = 0; $summcost = 0; foreach($names as $name):
                            
                            if($name['name'] != $_SESSION['statename']) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    $freq = 0; $cost = 0; $avreg = 0;
                                    foreach($rows as $row) {
                                        if($name['ID'] == $row['nameid']) {
                                            $freq += $row['freq'];
                                            $cost += round($row['cost'], 2);
                                        }
                                    }
                                    echo $name['name'];
                                    ?>
                                </td>
                                <td><?php echo $freq; $summfreq += $freq; ?></td>
                                <td><?php echo $cost; $summcost += $cost; ?></td>
                                <td><?php if($freq == 0) {echo 0;} else {echo round(($cost / $freq), 2);} ?></td>
                            </tr>
                        <?php } endforeach; ?>
                        <tr>
                            <th>الجمله</th>
                            <th><?php echo $summfreq; if($j == 2) { $frequncy = $summfreq; } ?></th>
                            <th><?php echo $summcost; if($j == 2) { $allcost = $summcost; }  ?></th>
                            <th><?php if($summfreq == 0) {echo 0;} else {echo round(($summcost / $summfreq), 2);} ?></th>
                        </tr>
                        <?php
                    } ?>
                </table>
            </div>
        </div>

        <?php
    }

}


}


function totalReport($date) {

    $cities = getAllFrom('ID, name', 'city', 'WHERE state = ' . $_SESSION['state'], '', 'ID', '');

    ?>

        <div class="tables-section">
            <div class="table-responsive">
                <table class="table table-bordered">

                    <tr>
                        <th>المحليه</th>
                        <th>التردد</th>
                        <th>التكلفه</th>
                    </tr>
                    <?php 
                    
                    $freq = 0; $cost = 0;
                    
                    foreach($cities as $city): 
                                                

        $sum = getOne('sum(freq) as freq, sum(cost) as cost', 'summ', " WHERE daate LIKE '%$date%'", 
        ' AND tnum = 2 AND city = ' . $city['ID'], 'ID', '');    
                        
                        
                        
                    ?>

                    <tr>
                        <td><?php echo $city['name']; ?></td>
                        <td><?php echo round($sum['freq'], 2); $freq += round($sum['freq'], 2);  ?></td>
                        <td><?php echo round($sum['cost'], 2); $cost += round($sum['cost'], 2);?></td>
                    </tr>

                    <?php endforeach; ?>

                    <tr>
                        <th>المجــــــموع</th>
                        <th><?php echo $freq; ?></th>
                        <th><?php echo $cost; ?></th>
                    </tr>
                </table>
            </div>
        </div>

        <?php

}


function duhReport($query, $query2, $querydate = null) {


    $nameOfType = array(

                '1' => 'بيانات مرافق تقديم الخدمة المباشرة',
                '2' =>  ' بيانات مرافق تقديم الخدمة غير المباشرة والشراكة'

        );

    $centers2 = getAllFrom('center.*, city.name as cityname, unit.name as unitname',
        'center', " INNER JOIN city ON center.city = city.ID INNER JOIN unit ON center.unit = unit.ID WHERE " . $query,
        '', 'ID', '');

    if($centers2 != null) { ?>




        <div class="tables-section <?php if($j != 1) { echo 'breakpage'; } ?>">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="3">تردد قوات الشرطه واسرهم على مرافق الخدمه</th>
                    </tr>
                    <tr>
                        <th>الرقم</th>
                        <th>إسم المرفق</th>
                        <th>التردد</th>
                    </tr>
                    <?php
                    $freqreport = 0;
                    $i = 1;
                    
                    $police = getOne('ID', 'tables', " WHERE name LIKE '%قوات الشرطة%'", '', 'ID', '');

                    foreach($centers2 as $center):
                        $freqcost = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 2 AND nameid = '. $police['ID'], $querydate, 'ID', '');

                        ?>
                        <tr>
                            <td><?php echo $i; $i++; ?></td>
                            <td><?php echo $center['name']; ?></td>
                            <td><?php $freqreport += $freqcost['freq']; echo $freqcost['freq']; ?></td>
                        </tr>
                    <?php
                    endforeach;

                    ?>
                    <tr>
                        <th colspan="2">المجموع</th>
                        <th><?php echo $freqreport; ?></th>
                    </tr>
                </table>
            </div>
        </div>





<?php
    }

    for($j = 1;$j <= 2;$j++ ) {

        if($j == 1) {
            $query1 = " AND type = 1";
        } else {
            $query1 = " AND type = 2 OR type = 3";
        }


    $centers = getAllFrom('center.*, city.name as cityname, unit.name as unitname',
        'center', " INNER JOIN city ON center.city = city.ID INNER JOIN unit ON center.unit = unit.ID WHERE " . $query,
        $query1, 'ID', '');



    if($centers != null) {


        ?>



        <div class="tables-section <?php if($j != 1) { echo 'breakpage'; } ?>">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="5"><?php echo $nameOfType[$j]; ?></th>
                    </tr>
                    <tr>
                        <th>الرقم</th>
                        <th>المحلية</th>
                        <th>الوحدة الإدارية</th>
                        <th>إسم المرفق</th>
                        <th>التردد</th>
                    </tr>
                    <?php
                    $freqreport = 0;
                    $i = 1;

                    foreach($centers as $center):
                        $freqcost = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 2', $query2, 'ID', '');

                        ?>
                        <tr>
                            <td><?php echo $i; $i++; ?></td>
                            <td><?php echo $center['cityname']; ?></td>
                            <td><?php echo $center['unitname']; ?></td>
                            <td><?php echo $center['name']; ?></td>
                            <td><?php $freqreport += $freqcost['freq']; echo $freqcost['freq']; ?></td>
                        </tr>
                    <?php
                    endforeach;

                    ?>
                    <tr>
                        <th colspan="4">المجموع</th>
                        <th><?php echo $freqreport; ?></th>
                    </tr>
                </table>
            </div>
        </div>
    <?php }

        }

}


function allCenters($query, $query2) {

    $nameOfType = array(

        '1' =>  'التردد على مرافق تقديم الخدمة المباشرة',
        '2' =>  'التردد على مرافق تقديم الخدمة غير المباشرة',
        '3' =>  'التردد على مرافق تقديم خدمة الشراكة'
    );



    for ($j = 0;$j <= 3; $j++) {


    $centers = getAllFrom('center.*, city.name as cityname',
        'center', " INNER JOIN city ON center.city = city.ID WHERE " . $query,
        "AND type = " . $j, 'ID', '');

    if($centers != null) {


        ?>

        <div class="tables-section breakpage">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="10"><?php echo $nameOfType[$j]; ?></th>
                    </tr>
                    <tr>
                        <th rowspan="2">إسم المرفق</th>
                        <th rowspan="2">التردد</th>
                        <th rowspan="2">التردد بالبطاقه القوميه</th>
                        <th rowspan="2">متوسط التردد اليومي للورديه</th>
                        <th rowspan="2">عدد المحالين للإختصاصي من المشتركين</th>
                        <th rowspan="2">معدل التحويل</th>
                        <th rowspan="2">تردد الغير مؤمن لهم</th>
                        <th colspan="3">إجمالي الإجراءات</th>
                    </tr>
                    <tr>
                        <th>كشف طبي</th>
                        <th>المعمل</th>
                        <th>عملية صغيرة</th>
                    </tr>
                    <?php
                    $freqreport = 0;
                    $cardfreq   = 0;
                    $dayfreq    = 0;
                    $proffreq   = 0;
                    $sumdayfreq = 0;
                    $changefreq = 0;
                    $sumchfreq  = 0;
                    $unhiffreq  = 0;
                    $statename = $_SESSION['statename'];
                    $cardname = getOne('ID', 'tables', " WHERE name = '$statename' AND tnum = 11 ",  "", 'ID', '');
                                    
                    foreach($centers as $center):
                        $freqcost = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 2', $query2, 'ID', '');
                        $card = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 11 AND state != ' . $cardname['ID'], $query2, 'ID', '');
                        $prof = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 12',  $query2, 'ID', '');
                        $change = getOne('sum(freq) as freq', 'summ', "WHERE center = " . $center['ID'] . ' AND tnum = 7',  $query2, 'ID', '');
                        $unhif = getOne('sum(freq) as freq', 'freq', "WHERE center = " . $center['ID'] . ' AND nameid = 103',  $query2, 'ID', '');
                        $dayfreq  = round(($freqcost['freq']/ 26), 2);
                        if($change['freq'] != 0) {
                            $cardfreq = round(($prof['freq'] / $change['freq']) * 100, 2);
                            $sumchfreq += $cardfreq;
                        } else {
                            $cardfreq = 0;
                            $sumchfreq += $cardfreq;
                        }
                        ?>
                        <tr>
                            <td><?php echo $center['name']; ?></td>
                            <td><?php $freqreport += $freqcost['freq']; echo $freqcost['freq']; ?></td>
                            <td><?php $cardfreq += $card['freq']; echo $card['freq']; ?></td>
                            <td><?php $sumdayfreq += $dayfreq; echo $dayfreq; ?></td>
                            <td><?php $proffreq += $prof['freq']; echo $prof['freq']; ?></td>
                            <td><?php echo $changefreq; ?></td>
                            <td><?php $unhiffreq += $unhif['freq']; echo $unhif['freq']; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    endforeach;

                    ?>
                    <tr>
                        <th colspan="1">المجموع</th>
                        <th><?php echo $freqreport; ?></th>
                        <th><?php echo $cardfreq; ?></th>
                        <th><?php echo $sumdayfreq; ?></th>
                        <th><?php echo $proffreq; ?></th>
                        <th><?php echo $sumchfreq; ?></th>
                        <th><?php echo $unhiffreq; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </table>
            </div>
        </div>
    <?php }

    }



}


function centerDetails($query, $query2) {

    $directcost = 0; $undirectcost = 0; $sharecost = 0; $dch = 0; $udch = 0; $totalcost = 0;
    $directfreq = 0; $undirectfreq = 0; $sharefreq = 0; $dfh = 0; $udfh = 0; $totalfreq = 0;


    ?>


    <div class="tables-section breakpage">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>نوع المرافق الصحيه</th>
                    <th>التردد</th>
                    <th>التكلفة</th>
                    <th>متوسط التكلفه</th>
                </tr>
                <tr>
                    <?php

                    $centers = getAllFrom('*', 'center', "WHERE " . $query, " AND category = 2 AND type = 1", 'ID', '');

                    foreach($centers as $center):

                        $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'summ', "WHERE center = " . $center['ID'], $query2 . " AND tnum = 2", 'ID', '');

                        if($freqcost != null) {
                            $directcost += $freqcost['cost'];
                            $directfreq += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>المراكز المباشرة</td>
                    <td><?php echo $directfreq; ?></td>
                    <td><?php echo $directcost; ?></td>
                    <td><?php if($directfreq != 0){ echo round(($directcost / $directfreq),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $centers = getAllFrom('*', 'center', "WHERE " . $query, " AND category = 2 AND type = 2", 'ID', '');

                    foreach($centers as $center):

                        $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'summ', "WHERE center = " . $center['ID'], $query2 . " AND tnum = 2", 'ID', '');

                        if($freqcost != null) {
                            $undirectcost += $freqcost['cost'];
                            $undirectfreq += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>المراكز غير المباشرة</td>
                    <td><?php echo $undirectfreq; ?></td>
                    <td><?php echo $undirectcost; ?></td>
                    <td><?php if($undirectfreq != 0){ echo round(($undirectcost / $undirectfreq),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $centers = getAllFrom('*', 'center', "WHERE " . $query, " AND category = 1 AND type = 1", 'ID', '');

                    foreach($centers as $center):

                        $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'summ', "WHERE center = " . $center['ID'], $query2 . " AND tnum = 2", 'ID', '');

                        if($freqcost != null) {
                            $dch += $freqcost['cost'];
                            $dfh += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>المستشفيات المباشره</td>
                    <td><?php echo $dfh; ?></td>
                    <td><?php echo $dch; ?></td>
                    <td><?php if($dfh != 0){ echo round(($dch / $dfh),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $centers = getAllFrom('*', 'center', "WHERE " . $query, " AND category = 1 AND type = 2", 'ID', '');

                    foreach($centers as $center):

                        $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'summ', "WHERE center = " . $center['ID'], $query2 . " AND tnum = 2", 'ID', '');

                        if($freqcost != null) {
                            $udch += $freqcost['cost'];
                            $udfh += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>المستشفيات غير المباشره</td>
                    <td><?php echo $udfh; ?></td>
                    <td><?php echo $udch; ?></td>
                    <td><?php if($udfh != 0){ echo round(($udch / $udfh),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $centers = getAllFrom('*', 'center', "WHERE " . $query, " AND type = 3", 'ID', '');

                    foreach($centers as $center):

                        $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'summ', "WHERE center = " . $center['ID'], $query2 . " AND tnum = 2", 'ID', '');

                        if($freqcost != null) {
                            $sharecost += $freqcost['cost'];
                            $sharefreq += $freqcost['freq'];
                        }

                    endforeach;

                    ?>

                    <td>مرافق الشراكه</td>
                    <td><?php echo $sharefreq; ?></td>
                    <td><?php echo $sharecost; ?></td>
                    <td><?php if($sharefreq != 0){ echo round(($sharecost / $sharefreq),2);} else { echo 0; } ?></td>
                </tr>
                <tr>
                    <?php

                    $totalfreq += $directfreq + $undirectfreq + $dfh + $udfh + $sharefreq;
                    $totalcost += $directcost + $undirectcost + $dch + $udch + $sharecost;


                    ?>

                    <th>المجموع</th>
                    <th><?php echo $totalfreq; ?></th>
                    <th><?php echo $totalcost; ?></th>
                    <th><?php if($totalfreq != 0){ echo round(($totalcost / $totalfreq),2);} else { echo 0; } ?></th>
                </tr>
            </table>
        </div>
    </div>





<?php
}


function pharmacyDetails($query) {


    for ($j = 1; $j <= 3; $j++) {

        $pharmacies = getAllFrom('*',
            'pharmacy', " WHERE type = " . $j,
            '', 'ID', '');

        if($pharmacies != null) {

            $nameOfType = array(

                '1' =>  'الصدليات المباشره',
                '2' =>  'الصدليات غير المباشره',
                '3' =>  'الصدليات المتعاقد معها',
                '4' =>  'صدليات المستشفيات'

            );




            if($j == 1) {
                ?>
                <div class="tables-section breakpage">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="7"><?php echo $nameOfType[$j]; ?></th>
                            </tr>
                            <tr>
                                <th>الرقم</th>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>%25</th>
                                <th>%75</th>
                                <th>الدواء التجاري</th>
                                <th>الجمله</th>
                            </tr>
                            <?php
                            $freqreport = 0;
                            $quarterreport = 0;
                            $threereport = 0;
                            $medicincostreport = 0;
                            $totalsum = 0;
                            $i = 1;

                            foreach ($pharmacies as $pharmacy):
                                $freq = getOne('sum(freq) as freq, sum(quarter) as quarter, sum(three) as three, sum(medicincost) as medicincost', 'pharmacysum', "WHERE pharmacy = " . $pharmacy['ID'], $query, 'ID', '');

                                $freqreport += $freq['freq'];
                                $quarterreport += $freq['quarter'];
                                $threereport += $freq['three'];
                                $medicincostreport += $freq['medicincost'];
                                ?>
                                <tr>
                                    <td><?php echo $i;
                                        $i++; ?></td>
                                    <td><?php echo $pharmacy['name']; ?></td>
                                    <td><?php echo $freq['freq']; ?></td>
                                    <td><?php echo $freq['quarter']; ?></td>
                                    <td><?php echo $freq['three']; ?></td>
                                    <td><?php echo $freq['medicincost']; ?></td>
                                    <td><?php echo($freq['freq'] + $freq['quarter'] + $freq['three'] + $freq['medicincost']); ?></td>
                                </tr>
                            <?php
                            endforeach;

                            ?>
                            <tr>
                                <th colspan="2">المجموع</th>
                                <th><?php echo $freqreport; ?></th>
                                <th><?php echo $quarterreport; ?></th>
                                <th><?php echo $threereport; ?></th>
                                <th><?php echo $medicincostreport; ?></th>
                                <th><?php echo $freqreport + $quarterreport + $threereport + $medicincostreport; ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php


            } else {


                ?>
                <div class="tables-section">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="5"><?php echo $nameOfType[$j]; ?></th>
                            </tr>
                            <tr>
                                <th>الرقم</th>
                                <th>إسم الصيدلية</th>
                                <th>التردد</th>
                                <th>%75</th>
                                <th>متوسط التكلفة</th>
                            </tr>
                            <?php
                            $freqreport = 0;
                            $threereport = 0;
                            $totalsum = 0;
                            $i = 1;

                            foreach ($pharmacies as $pharmacy):
                                $freq = getOne('sum(freq) as freq, sum(three) as three', 'pharmacysum', "WHERE pharmacy = " . $pharmacy['ID'], $query, 'ID', '');

                                $freqreport += $freq['freq'];
                                $threereport += $freq['three'];
                                ?>
                                <tr>
                                    <td><?php echo $i;
                                        $i++; ?></td>
                                    <td><?php echo $pharmacy['name']; ?></td>
                                    <td><?php echo $freq['freq']; ?></td>
                                    <td><?php echo $freq['three']; ?></td>
                                    <td><?php if($freq['freq'] == 0) {echo 0;} else {echo round($freq['three'] / $freq['freq'], 2);} ?></td>
                                </tr>
                            <?php
                            endforeach;

                            ?>
                            <tr>
                                <th colspan="2">المجموع</th>
                                <th><?php echo $freqreport; ?></th>
                                <th><?php echo $threereport; ?></th>
                                <th><?php if($freqreport != 0) { round($threereport / $freqreport, 2); } else {echo 0; } ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php



            }

            }

    }




}



function pharmacyTotal($query) {





    $directcost = 0; $undirectcost = 0; $sharecost = 0; $dch = 0; $udch = 0; $restorc = 0; $totalcost = 0;
    $directfreq = 0; $undirectfreq = 0; $sharefreq = 0; $dfh = 0; $udfh = 0; $restorf = 0; $totalfreq = 0;


    ?>


    <div class="tables-section breakpage">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>البيان</th>
                    <th>جملة المترددين على الصيدلية</th>
                    <th>تكلفة الـ75%</th>
                    <th>متوسط التكلفه</th>
                </tr>
                <tr>
                    <?php

                    $pharmcies = getAllFrom('*', 'pharmacy', "WHERE state = " . $_SESSION['state'], " AND type = 1", 'ID', '');

                    foreach($pharmcies as $pharmcy):

                        $freqcost = getOne('sum(freq) as freq , sum(three) as three', 'pharmacysum', "WHERE state = " . $_SESSION['state'] . ' AND pharmacy = ' . $pharmcy['ID'], $query, 'ID', '');

                        if($freqcost != null) {
                            $directcost += $freqcost['three'];
                            $directfreq += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>تكلفة أدوية الصيدليات المباشرة</td>
                    <td><?php echo $directfreq; ?></td>
                    <td><?php echo $directcost; ?></td>
                    <td><?php if($directfreq != 0){ echo round(($directcost / $directfreq),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $pharmcies = getAllFrom('*', 'pharmacy', "WHERE state = " . $_SESSION['state'], " AND type = 2", 'ID', '');

                    foreach($pharmcies as $pharmcy):

                        $freqcost = getOne('sum(freq) as freq , sum(three) as three', 'pharmacysum', "WHERE state = " . $_SESSION['state'] . ' AND pharmacy = ' . $pharmcy['ID'], $query, 'ID', '');

                        if($freqcost != null) {
                            $undirectcost += $freqcost['three'];
                            $undirectfreq += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>تكلفة أدوية الصيدليات غيرالمباشرة</td>
                    <td><?php echo $undirectfreq; ?></td>
                    <td><?php echo $undirectcost; ?></td>
                    <td><?php if($undirectfreq != 0){ echo round(($undirectcost / $undirectfreq),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $pharmcies = getAllFrom('*', 'pharmacy', "WHERE state = " . $_SESSION['state'], " AND type = 3", 'ID', '');

                    foreach($pharmcies as $pharmcy):

                        $freqcost = getOne('sum(freq) as freq , sum(three) as three', 'pharmacysum', "WHERE state = " . $_SESSION['state'] . ' AND pharmacy = ' . $pharmcy['ID'], $query, 'ID', '');

                        if($freqcost != null) {
                            $dch += $freqcost['three'];
                            $dfh += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>تكلفة أدوية المستشفيات (الدواء الدوار)</td>
                    <td><?php echo $dfh; ?></td>
                    <td><?php echo $dch; ?></td>
                    <td><?php if($dfh != 0){ echo round(($dch / $dfh),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php

                    $pharmcies = getAllFrom('*', 'pharmacy', "WHERE state = " . $_SESSION['state'], " AND type = 4", 'ID', '');

                    foreach($pharmcies as $pharmcy):

                        $freqcost = getOne('sum(freq) as freq , sum(three) as three', 'pharmacysum', "WHERE state = " . $_SESSION['state'] . ' AND pharmacy = ' . $pharmcy['ID'], $query, 'ID', '');

                        if($freqcost != null) {
                            $udch += $freqcost['three'];
                            $udfh += $freqcost['freq'];
                        }

                    endforeach;

                    ?>
                    <td>تكلفة أدوية الصيدليات المتعاقد معها التجاريه</td>
                    <td><?php echo $udfh; ?></td>
                    <td><?php echo $udch; ?></td>
                    <td><?php if($udfh != 0){ echo round(($udch / $udfh),2);} else { echo 0; } ?></td>
                </tr>
                <tr>

                    <?php


                    $freqcost = getOne('sum(freq) as freq , sum(cost) as cost', 'restorcost', "WHERE state = " . $_SESSION['state'], $query, 'ID', '');

                    if($freqcost != null) {
                        $restorc += $freqcost['cost'];
                        $restorf += $freqcost['freq'];
                    }


                    ?>

                    <td>استرداد دواء</td>
                    <td><?php echo $restorf; ?></td>
                    <td><?php echo $restorc; ?></td>
                    <td><?php if($restorf != 0){ echo round(($restorc / $restorf),2);} else { echo 0; } ?></td>
                </tr>
                <tr>
                    <?php

                    $totalfreq += $directfreq + $undirectfreq + $dfh + $udfh + $restorf;
                    $totalcost += $directcost + $undirectcost + $dch + $udch + $restorc;


                    ?>

                    <th>المجموع</th>
                    <th><?php echo $totalfreq; ?></th>
                    <th><?php echo $totalcost; ?></th>
                    <th><?php if($totalfreq != 0){ echo round(($totalcost / $totalfreq),2);} else { echo 0; } ?></th>
                </tr>
            </table>
        </div>
    </div>





    <?php














}


function getCensus($daate) {
    
    $rows = getAllFrom('census.*, city.name', 'census', "INNER JOIN city ON census.city = city.ID WHERE daate = '$daate' " , '', 'ID', '');

    
?>

      <?php if($rows != null){ ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>المحليه</th>
              <th>عدد السكان</th>
            </tr>
            <?php $sum = 0; foreach($rows as $row): $sum += $row['census']; ?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td>
                <?php echo $row['census']; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <th>المجموع</th>
            <th><?php echo $sum; ?></th>
          </tr>
          </table>
          
        </div>
    <?php } else { 
    
        $rows = getAllFrom('*', 'city', "WHERE state = " . $_SESSION['state'] , '', 'ID', '');
        
    ?>

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>المحليه</th>
              <th>عدد السكان</th>
            </tr>
            <?php $sum = 0; foreach($rows as $row):?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td></td>
            </tr>
          <?php endforeach; ?>

          <tr>
            <th>المجموع</th>
            <th><?php echo $sum; ?></th>
          </tr>


          </table>
          
        </div>


    <?php } ?>

<?php
}


?>
