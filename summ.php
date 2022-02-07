<?php
  session_start();

  if(isset($_SESSION['user']) || isset($_SESSION['admin'])) {

    if(isset($_SESSION['center'])) {

        include 'init.php';

        $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');

        $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

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

      $day = array(

        '0'  =>  'كل الورديات',
        '1'  =>  'صباحيه',
        '2'  =>  'مسائية',    

      );

        if($do == 'mange') {

            if(isset($_SESSION['daate'])) {
              $date = $_SESSION['daate'];
              $daay = $_SESSION['day'];
            } else {
              header('Location: center.php');
            }



        ?>


          <div class="container">
          <div class="alert alert-info"><ul><li><?php echo $rows['name']; ?></li><li><?php echo $_SESSION['daate']; ?></li><li><?php echo $day[$_SESSION['day']]; ?></li></ul></div>
          <?php

          $ifnull = 0;

          if($daay == 0) {
            $query = " ";
          } else {
            $query = " AND day = " . $daay;
          }


          for ($j = 1; $j <= 17; $j++) {

            if($j == 3) {

              $rows = getAllFrom('*', 'summt', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

              $chrows = checkrow('*', 'summt', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . " AND day = 0 ", 'ID', '');


            }elseif($j == 4 || $j == 13 || $j == 14 || $j == 16) {

              $rows = getAllFrom('*', 'freq', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

              $chrows = checkrow('*', 'freq', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . " AND day = 0 ", 'ID', '');


            } elseif($j == 17) {

              $rows = getAllFrom('*', 'summp', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

              $chrows = checkrow('*', 'summp', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . " AND day = 0 ", 'ID', '');


            } else {

              $rows = getAllFrom('*', 'summ', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

              $chrows = checkrow('*', 'summ', 'WHERE tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . " AND day = 0 ", 'ID', '');


            }

            $names = getAllFrom('ID, name', 'tables', 'WHERE tnum = ' . $j, '', 'ID', '');

            if($rows != null) { ?>

              <div class="tables-section">
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
                  <?php foreach($names as $name):?>
                  <th>
                    <?php echo $name['name']; ?>
                  </th>
                  <?php endforeach;?>

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
                    <th colspan="6"><?php echo $arrayTable[$j]; ?></th>
                </tr>
                <tr>
                    <th>البيان</th>
                    <th>عدد المترددين</th>
                    <th>تكليفة الخدمه المقابله</th>
                    <th>تكلفة الخدمات</th>
                    <th>تكليفة العمليات</th>
                    <th>التكلفة الكليه</th>
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
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <th>الجمله</th>
                    <th><?php echo $totalf; ?></th>
                    <th><?php echo $totalc; ?></th>
                    <th><?php echo $totals; ?></th>
                    <th><?php echo $totalj; ?></th>
                    <th><?php echo ($totalc + $totals + $totalj); ?></th>
                </tr>

                <?php
    }  elseif($j == 4 || $j == 14 || $j == 16) {  ?>

                <tr>
                    <th colspan="2"><?php echo $arrayTable[$j]; ?></th>
                </tr>
                <tr>
                    <th>البيان</th>
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

    } elseif($j == 17) { ?>

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
      </tr>
      <?php $summfreq = 0; $summcost = 0; foreach($names as $name):
          
          if($name['name'] != $_SESSION['statename']) {
          ?>
          <tr>
              <td>
                  <?php
                  $freq = 0; $cost = 0;
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
          </tr>
      <?php } endforeach; ?>
      <tr>
          <th>الجمله</th>
          <th><?php echo $summfreq; if($j == 2) { $frequncy = $summfreq; } ?></th>
          <th><?php echo $summcost; if($j == 2) { $allcost = $summcost; }  ?></th>
      </tr>
      <?php
  } ?>
              </table>
            </div>
          <?php if($daay == 0 && $chrows > 0){ ?>
            <a class="btn btn-primary" href="?do=edit&ID=<?php echo $row['tnum'] ?>&daate=<?php echo $date; ?>&day=<?php echo $daay; ?>">تعديل</a>
          <?php }elseif($daay != 0){ ?>
            <a class="btn btn-primary" href="?do=edit&ID=<?php echo $row['tnum'] ?>&daate=<?php echo $date; ?>&day=<?php echo $daay; ?>">تعديل</a>
            <?php
          } ?>
          </div>

            <?php
          } else {
            $ifnull += 1;
          }

          }

          if($ifnull > 15) {  ?>

              <div style="margin-top: 50px" class="container alert alert-danger">
                <ul>
                  <li>عفواً هذا التقرير لم يتم إعداده بعد</li>
                </ul>
              </div>

            <?php
          }
          ?>

        </div>
          <?php

        } elseif($do == 'add') { ?>

          <div class="container">

          <?php

          $rows = getOne('ID, name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', ''); ?>
          <div class="alert alert-info"><ul><li><?php echo $rows['name']; ?></li><li><?php echo $_SESSION['daate']; ?></li><li><?php echo $day[$_SESSION['day']]; ?></li></ul></div>


          <?php
          
          $checkval = 0;

          if (isset($_SESSION['daate']) && $_SESSION['daate'] != null && $_SESSION['daate'] != 0) {

          $date = $_SESSION['daate'];
          $daay = $_SESSION['day'];

          if($daay == 0) {
            $query = " AND day IN (0, 1, 2) ";
          } else {
            $query = " AND day IN (0, $daay) ";
          }

          for ($j = 1;$j <= 17; $j++) {


            if($j == 3) {

              $addCeck = checkrow('ID', 'summt', 'where tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

            }elseif($j == 4 || $j == 13 || $j == 14 || $j == 16) {

              $addCeck = checkrow('ID', 'freq', 'where tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

            }elseif($j == 17) {

              $addCeck = checkrow('ID', 'summp', 'where tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

            } else {

              $addCeck = checkrow('ID', 'summ', 'where tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'] . $query, 'ID', '');

            }

              if($addCeck == 0) {

                $rows = getAllFrom('*', 'tables', 'WHERE tnum = ' . $j, '', 'ID', '');

                if($rows != null){

                ?>

                <div class="tables-section">
                    <form class="" action="?do=insert" method="post">
                      <input type="hidden" name="tnum" value="<?php echo $j; ?>">
                      <input type="hidden" name="daate" value="<?php echo $date; ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">

                        <?php if($j == 1){ ?>

                        <tr>
                          <th colspan="<?php echo count($rows) + 1; ?>"><?php echo $arrayTable[$j]; ?></th>
                        </tr>

                        <tr>
                          <th rowspan="2">البيان</th>
                          <th colspan="<?php echo count($rows); ?>">الفــــــــــئات العمريه</th>
                        </tr>
                        <tr>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <th>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php echo $row['name']; ?>
                          </th>
                          <?php $i = $i + 1; ?>
                          <?php endforeach;?>

                        </tr>
                        <tr>
                          <th>ذكر</th>
                          <?php for ($i = 1; $i <= count($rows) ; $i++):?>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <?php endfor; ?>
                        </tr>
                        <tr>
                          <th>إنثى</th>
                          <?php for ($i = 1; $i <= count($rows) ; $i++):?>
                            <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <?php endfor; ?>
                        </tr>

                        <?php
                      } elseif($j == 3) { ?>

                        <tr>
                          <th colspan="5"><?php echo $arrayTable[$j]; ?></th>
                        </tr>

                        <tr>
                          <th>البيان</th>
                          <th>عدد المترددين</th>
                          <th>تكليفة الخدمه المقابله</th>
                          <th>تكلفة الخدمات</th>
                          <th>تكليفة العمليات</th>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach($rows as $row):?>
                        <tr>
                          <td>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php
                              echo $row['name'];
                            ?>
                          </td>
                          <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <td><input name="<?php echo 'servcost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <td><input name="<?php echo 'jobcost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                        </tr>
                        <?php $i = $i + 1; ?>
                      <?php endforeach; ?>


                    <?php
                  } elseif($j == 4 || $j == 14 || $j == 16) { ?>

                    <tr>
                      <th colspan="2"><?php echo $arrayTable[$j]; ?></th>
                    </tr>

                      <tr>
                        <th>البيان</th>
                        <th>التردد</th>
                      </tr>
                      <?php $i = 1; ?>
                      <?php foreach($rows as $row):?>
                      <tr>
                        <td>
                          <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                          <?php
                            echo $row['name'];
                          ?>
                        </td>
                        <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                      </tr>
                      <?php $i = $i + 1; ?>
                    <?php endforeach; ?>


                  <?php
                  } elseif($j == 5) { ?>

                    <tr>
                      <th colspan="<?php echo count($rows) + 1; ?>"><?php echo $arrayTable[$j]; ?></th>
                    </tr>

                    <tr>
                      <th>المرض</th>
                      <?php $i = 1; ?>
                      <?php foreach($rows as $row):?>
                      <th>
                        <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                        <?php echo $row['name']; ?>
                      </th>
                      <?php $i = $i + 1; ?>
                      <?php endforeach;?>
                    </tr>
                    <tr>
                      <th>التردد</th>
                      <?php for ($i = 1; $i <= count($rows) ; $i++):?>
                        <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                      <?php endfor; ?>
                    </tr>
                    <tr>
                      <th>التكلفة</th>
                      <?php for ($i = 1; $i <= count($rows) ; $i++):?>
                        <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                      <?php endfor; ?>
                    </tr>

                    <?php
                  } elseif($j == 6) {?>

                    <tr>
                      <th colspan="3"><?php echo $arrayTable[$j]; ?></th>
                    </tr>

                    <tr>
                      <th>الخدمه</th>
                      <th>التردد</th>
                      <th>التكلفه</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach($rows as $row):?>
                    <tr>
                      <td>
                        <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                        <?php
                          echo $row['name'];
                        ?>
                      </td>
                      <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                      <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                    </tr>
                    <?php $i = $i + 1; ?>
                  <?php endforeach; ?>

                  <?php } elseif($j == 13) { ?>

                          <tr>
                            <th colspan="<?php echo count($rows); ?>"><?php echo $arrayTable[$j]; ?></th>
                          </tr>

                          <tr>
                            <?php $i = 1; ?>
                            <?php foreach($rows as $row):?>
                            <th>
                              <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                              <?php echo $row['name']; ?>
                            </th>
                            <?php $i = $i + 1; ?>
                            <?php endforeach;?>
                          </tr>
                          <tr>
                            <?php $i = 1; ?>
                            <?php foreach($rows as $row):?>
                              <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                              <?php $i = $i + 1; ?>
                            <?php endforeach;?>
                          </tr>

                  <?php
                    }elseif($j == 17) {  ?>

                        <tr>
                          <th colspan="4"><?php echo $arrayTable[$j]; ?></th>
                        </tr>

                        <tr>
                          <th>البيان</th>
                          <th>عدد المترددين</th>
                          <th>عدد الخدمات</th>
                          <th>التكلفة الكليه</th>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach($rows as $row):?>
                        <tr>
                          <td>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php
                              echo $row['name'];
                            ?>
                          </td>
                          <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <td><input name="<?php echo 'servcost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                        </tr>
                        <?php $i = $i + 1; ?>
                      <?php endforeach; ?>


                    <?php
                  } else { ?>

                          <tr>
                            <th colspan="3"><?php echo $arrayTable[$j]; ?></th>
                          </tr>

                          <tr>
                            <th>البيان</th>
                            <th>التردد</th>
                            <th>التكلفه</th>
                          </tr>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <tr>
                            <td>
                              <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                              <?php
                                echo $row['name'];
                              ?>
                            </td>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                            <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" autocomplete="off" /></td>
                          </tr>
                          <?php $i = $i + 1; ?>
                        <?php endforeach; ?>

                      <?php
                    } ?>

                      </form>
                      </table>
                    </div>
                    <input class="form-control btn-primary" type="submit" value="حفظ">
                </div>



            <?php
              }
          } else {
            $checkval++;
            if($checkval == 17) { ?>

              <div class="text-center alert alert-success">تم إدخال بيانات هذا المركز مسبقاً</div>

            <?php
            }
          }

        }
      } else {

        header('Location: adddata.php');

      } ?>

      </div>

        <?php

          } elseif($do == 'insert' ) {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

              $tnum = $_POST['tnum'];
              $date = $_POST['daate'];

              $insertCheck = 0;

                if($tnum == 3) {

                  $count = (count($_POST) / 5);

                  for($i = 1;$i <= $count;$i = $i + 1){

                      $id       = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                      $freq     = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                      $cost     = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);

                      $servcost = filter_var($_POST['servcost' . $i], FILTER_VALIDATE_FLOAT);

                      $jobcost  = filter_var($_POST['jobcost' . $i], FILTER_VALIDATE_FLOAT);
                      $checkInsert = checkrow('ID', 'summt', ' WHERE tnum = ' . $tnum . ' AND nameid = ' . $id . ' AND day = ' . $_SESSION['day'] . ' AND center = ' . $_SESSION['center'], " AND daate = '$date' ", 'ID', '');
                      if($checkInsert == 0){
                      $stmt = $con->prepare("INSERT INTO
                                            summt(tnum, nameid, freq, cost, servcost, jobcost, state, city, center, day, daate)
                                            VALUES(:tnum, :nameid, :freq, :cost, :servcost, :job, :state, :city, :center, :day, :d) ");


                      $stmt->execute(array(

                                      'tnum'      =>  $tnum,
                                      'nameid'    =>  $id,
                                      'freq'      =>  $freq,
                                      'cost'      =>  $cost,
                                      'servcost'  =>  $servcost,
                                      'job'       =>  $jobcost,
                                      'state'     =>  $_SESSION['state'],
                                      'city'      =>  $_SESSION['city'],
                                      'center'    =>  $_SESSION['center'],
                                      'day'       =>  $_SESSION['day'],
                                      'd'         =>  $date

                              ));

                    $inserted = $stmt->rowCount();

                    $insertCheck++;
                  }


                }
                
                

                if($insertCheck != 0){ ?>
                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
                }else{ ?>

                <div class="container text-center alert alert-danger">تمت اضافة هذه البيانات مسبقاً</div>

                <?php

                }

                } elseif($tnum == 4 || $tnum == 13 || $tnum == 14 || $tnum == 16) {

                  $count = (count($_POST) / 2) - 1;

                  for($i = 1;$i <= $count;$i = $i + 1){

                      $id   = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                      $freq = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                    $checkInsert = checkrow('ID', 'freq', ' WHERE tnum = ' . $tnum . ' AND nameid = ' . $id . ' AND day = ' . $_SESSION['day'] . ' AND center = ' . $_SESSION['center'], " AND daate = '$date' ", 'ID', '');
                    if($checkInsert == 0){



                      $stmt = $con->prepare("INSERT INTO
                                            freq(tnum, nameid, freq, state, city, center, day, daate)
                                            VALUES(:tnum,:nameid, :freq, :state, :city, :center, :day, :d) ");


                      $stmt->execute(array(

                                      'tnum'      =>  $tnum,
                                      'nameid'    =>  $id,
                                      'freq'      =>  $freq,
                                      'state'     =>  $_SESSION['state'],
                                      'city'      =>  $_SESSION['city'],
                                      'center'    =>  $_SESSION['center'],
                                      'day'       =>  $_SESSION['day'],
                                      'd'         =>  $date

                              ));

                    $inserted = $stmt->rowCount();

                    $insertCheck++;

                  }

                  } 

                if($insertCheck != 0){ ?>
                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
                }else{ ?>

                <div class="container text-center alert alert-danger">تمت اضافة هذه البيانات مسبقاً</div>

                <?php

                }             
                } elseif($tnum == 17) {





                  $count = (count($_POST) / 4);

                  for($i = 1;$i <= $count;$i = $i + 1){

                      $id       = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                      $freq     = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                      $cost     = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);

                      $servcost = filter_var($_POST['servcost' . $i], FILTER_VALIDATE_FLOAT);

                      $checkInsert = checkrow('ID', 'summp', ' WHERE tnum = ' . $tnum . ' AND nameid = ' . $id . ' AND day = ' . $_SESSION['day'] . ' AND center = ' . $_SESSION['center'], " AND daate = '$date' ", 'ID', '');
                      if($checkInsert == 0){
                      $summp = $con->prepare("INSERT INTO
                                            summp(tnum, nameid, freq, cost, servcost, state, city, center, day, daate)
                                            VALUES(:tnum, :nameid, :freq, :cost, :servcost, :state, :city, :center, :day, :d) ");


                      $summp->execute(array(

                                      'tnum'      =>  $tnum,
                                      'nameid'    =>  $id,
                                      'freq'      =>  $freq,
                                      'cost'      =>  $cost,
                                      'servcost'  =>  $servcost,
                                      'state'     =>  $_SESSION['state'],
                                      'city'      =>  $_SESSION['city'],
                                      'center'    =>  $_SESSION['center'],
                                      'day'       =>  $_SESSION['day'],
                                      'd'         =>  $date

                              ));

                    $inserted = $summp->rowCount();

                    $insertCheck++;
                  }


                }
                
                

                if($insertCheck != 0){ ?>
                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
                }else{ ?>

                <div class="container text-center alert alert-danger">تمت اضافة هذه البيانات مسبقاً</div>

                <?php

                }

                



                } else {

                  $count = (count($_POST) / 3);

                  for($i = 1;$i <= $count;$i = $i + 1){

                      $id   = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                      $freq = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                      $cost = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);
                    $checkInsert = checkrow('ID', 'summ', ' WHERE tnum = ' . $tnum . ' AND nameid = ' . $id . ' AND day = ' . $_SESSION['day'] . ' AND center = ' . $_SESSION['center'], " AND daate = '$date' ", 'ID', '');
                    if($checkInsert == 0){
                      $stmt = $con->prepare("INSERT INTO
                                            summ(tnum, nameid, freq, cost, state, city, center, day, daate)
                                            VALUES(:tnum,:nameid, :freq, :cost, :state, :city, :center, :day, :d) ");


                      $stmt->execute(array(

                                      'tnum'      =>  $tnum,
                                      'nameid'    =>  $id,
                                      'freq'      =>  $freq,
                                      'cost'      =>  $cost,
                                      'state'     =>  $_SESSION['state'],
                                      'city'      =>  $_SESSION['city'],
                                      'center'    =>  $_SESSION['center'],
                                      'day'       =>  $_SESSION['day'],
                                      'd'         =>  $date

                              ));

                    $inserted = $stmt->rowCount();
                    $insertCheck++;
                  }
                }
                


                if($insertCheck != 0){ ?>
                <div class="container text-center alert alert-success">تمت الإضافه بنجاح</div>

              <?php
                }else{ ?>

                <div class="container text-center alert alert-danger">تمت اضافة هذه البيانات مسبقاً</div>

                <?php

                }                
                }


                header("refresh: 3; url = summ.php?do=add");

            } else {

              echo "لا يمكنك الدخول الى هذه الصفحه مباشرةً";

            }


          } elseif($do == 'edit') {

            $j = (isset($_GET['ID']) && is_numeric($_GET['ID'])) ? intval($_GET['ID']) : 0;
            $day = (isset($_GET['day']) && is_numeric($_GET['day'])) ? intval($_GET['day']) : 0;
            $date = filter_var($_GET['daate'], FILTER_SANITIZE_STRING);

            if($j == 3) {

              $rows = getAllFrom('summt.*, tables.name as name', 'summt', 'INNER JOIN tables ON tables.ID = summt.nameid WHERE summt.tnum = ' . $j, "AND center = " . $_SESSION['center'] . " AND day = $day " . " AND daate = '$date' ", 'ID', '');

            }elseif($j == 4 || $j == 13 || $j == 14 || $j == 16) {

              $rows = getAllFrom('freq.*, tables.name as name', 'freq', 'INNER JOIN tables ON tables.ID = freq.nameid WHERE freq.tnum = ' . $j, "AND center = " . $_SESSION['center'] . " AND day = $day " . " AND daate = '$date' ", 'ID', '');

            } elseif($j == 17) {


              $rows = getAllFrom('summp.*, tables.name as name', 'summp', 'INNER JOIN tables ON tables.ID = summp.nameid WHERE summp.tnum = ' . $j, "AND center = " . $_SESSION['center'] . " AND day = $day " . " AND daate = '$date' ", 'ID', '');



            } else {

              $rows = getAllFrom('summ.*, tables.name as name', 'summ', 'INNER JOIN tables ON tables.ID = summ.nameid WHERE summ.tnum = ' . $j, "AND center = " . $_SESSION['center'] . " AND day = $day " . " AND daate = '$date' ", 'ID', '');

            }

            if($rows != null) {

              ?>

              <div class="container">

                    <div class="tables-section">
                        <form class="" action="?do=update" method="post">
                          <input type="hidden" name="tnum" value="<?php echo $j; ?>">
                        <div class="table-responsive">
                          <table class="table table-bordered">

                            <?php if($j == 1){ ?>

                            <tr>
                              <th rowspan="2">البيان</th>
                              <th colspan="<?php echo count($rows); ?>">الفــــــــــئات العمريه</th>
                            </tr>
                            <tr>
                              <?php $i = 1; ?>
                              <?php foreach($rows as $row):?>
                              <th>
                                <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                                <?php echo $row['name']; ?>
                              </th>
                              <?php $i = $i + 1; ?>
                              <?php endforeach;?>

                            </tr>
                            <tr>
                              <th>ذكر</th>
                              <?php $i = 1; ?>
                              <?php foreach($rows as $row):?>
                                <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq']; ?>" /></td>
                              <?php $i = $i + 1; ?>
                              <?php endforeach;?>
                            </tr>
                            <tr>
                              <th>إنثى</th>
                              <?php $i = 1; ?>
                              <?php foreach($rows as $row):?>
                                <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost']; ?>" /></td>
                              <?php $i = $i + 1; ?>
                              <?php endforeach;?>
                            </tr>

                            <?php
                          } elseif($j == 3) { ?>

                          <tr>
                            <th>البيان</th>
                            <th>عدد المترددين</th>
                            <th>تكليفة الخدمه المقابله</th>
                            <th>تكلفة الخدمات</th>
                            <th>تكليفة العمليات</th>
                          </tr>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <tr>
                            <td>
                              <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                              <?php
                                echo $row['name'];
                              ?>
                            </td>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                            <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost'] ?>" /></td>
                            <td><input name="<?php echo 'servcost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['servcost'] ?>" /></td>
                            <td><input name="<?php echo 'jobcost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['jobcost'] ?>" /></td>
                          </tr>
                          <?php $i = $i + 1; ?>
                        <?php endforeach; ?>


                        <?php
                      } elseif($j == 4 || $j == 14 || $j == 16) { ?>

                          <tr>
                            <th>المرض</th>
                            <th>التردد</th>
                          </tr>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <tr>
                            <td>
                              <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                              <?php
                                echo $row['name'];
                              ?>
                            </td>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                          </tr>
                          <?php $i = $i + 1; ?>
                        <?php endforeach; ?>


                      <?php
                      } elseif($j == 5) { ?>

                        <tr>
                          <th>المرض</th>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <th>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php echo $row['name']; ?>
                          </th>
                          <?php $i = $i + 1; ?>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <th>التردد</th>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                            <?php $i = $i + 1; ?>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <th>التكلفة</th>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                            <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost'] ?>" /></td>
                            <?php $i = $i + 1; ?>
                          <?php endforeach;?>
                        </tr>

                        <?php
                      } elseif($j == 6) {?>

                        <tr>
                          <th>الخدمه</th>
                          <th>التردد</th>
                          <th>التكلفه</th>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach($rows as $row):?>
                        <tr>
                          <td>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php
                              echo $row['name'];
                            ?>
                          </td>
                          <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                          <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost'] ?>" /></td>
                        </tr>
                        <?php $i = $i + 1; ?>
                      <?php endforeach; ?>

                  <?php } elseif($j == 13) { ?>

                    <tr>
                      <th colspan="<?php echo count($rows); ?>"><?php echo $arrayTable[$j]; ?></th>
                    </tr>

                    <tr>
                      <?php $i = 1; ?>
                      <?php foreach($rows as $row):?>
                      <th>
                        <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                        <?php echo $row['name']; ?>
                      </th>
                      <?php $i = $i + 1; ?>
                      <?php endforeach;?>
                    </tr>
                    <tr>
                      <?php $i = 1; ?>
                      <?php foreach($rows as $row):?>
                        <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq']; ?>" /></td>
                        <?php $i = $i + 1; ?>
                      <?php endforeach;?>
                    </tr>

                      <?php
                      } elseif($j == 17) { ?>

                        <tr>
                          <th colspan="4"><?php echo $arrayTable[$j]; ?></th>
                        </tr>

                        <tr>
                          <th>البيان</th>
                          <th>عدد المترددين</th>
                          <th>عدد الخدمات</th>
                          <th>التكلفة الكليه</th>
                        </tr>
                          <?php $i = 1; ?>
                          <?php foreach($rows as $row):?>
                          <tr>
                            <td>
                              <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                              <?php
                                echo $row['name'];
                              ?>
                            </td>
                            <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                            <td><input name="<?php echo 'servcost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['servcost'] ?>" /></td>
                            <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost'] ?>" /></td>              
                          </tr>
                          <?php $i = $i + 1; ?>
                        <?php endforeach; ?>



                    <?php
                  





                      } else { ?>

                        <tr>
                          <th>البيان</th>
                          <th>التردد</th>
                          <th>التكلفه</th>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach($rows as $row):?>
                        <tr>
                          <td>
                            <input name="<?php echo 'ID' . $i ; ?>" type="hidden" value="<?php echo $row['ID'] ?>" />
                            <?php
                              echo $row['name'];
                            ?>
                          </td>
                          <td><input name="<?php echo 'freq' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['freq'] ?>" /></td>
                          <td><input name="<?php echo 'cost' . $i ; ?>" class="form-control" type="text" value="<?php echo $row['cost'] ?>" /></td>
                        </tr>
                        <?php $i = $i + 1; ?>
                      <?php endforeach; ?>

                          <?php
                        } ?>

                          </form>
                          </table>
                        </div>
                        <input class="form-control btn-primary" type="submit" value="حفظ">
                    </div>

          </div>

          <?php

         }

          } elseif($do == 'update') {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

              $tnum = $_POST['tnum'];

              if($tnum == 3) {

                $count = (count($_POST) / 5);

                for($i = 1;$i <= $count;$i = $i + 1){

                    $id   = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                    $freq     = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                    $cost     = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);

                    $servcost = filter_var($_POST['servcost' . $i], FILTER_VALIDATE_FLOAT);

                    $jobcost  = filter_var($_POST['jobcost' . $i], FILTER_VALIDATE_FLOAT);

                    $stmt = $con->prepare("UPDATE summt SET
                          freq = ?, cost = ?, servcost = ?, jobcost = ? WHERE ID = ?");

                    $stmt->execute(array($freq, $cost, $servcost, $jobcost, $id));

                    $rowscount = $stmt->rowCount();

                }

                echo "<div class='container'><div class='text-center alert alert-success'>تم التعديل بنجاح</div></div>";

              } elseif($tnum == 4 || $tnum == 13 || $tnum == 14 || $tnum == 16) {

                $count = (count($_POST) / 2);

                for($i = 1;$i <= $count;$i = $i + 1){

                    $id   = $_POST['ID' . $i];

                    $freq = $_POST['freq' . $i];

                    $stmt = $con->prepare("UPDATE freq SET
                          freq = ? WHERE ID = ?");

                    $stmt->execute(array($freq, $id));

                    $rowscount = $stmt->rowCount();

                }

                echo "<div class='container'><div class='text-center alert alert-success'>تم التعديل بنجاح</div></div>";

              } elseif($tnum == 17) {


                
                $count = (count($_POST) / 4);

                for($i = 1;$i <= $count;$i = $i + 1){

                    $id   = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                    $freq     = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                    $cost     = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);

                    $servcost = filter_var($_POST['servcost' . $i], FILTER_VALIDATE_FLOAT);


                    $stmt = $con->prepare("UPDATE summp SET
                          freq = ?, cost = ?, servcost = ? WHERE ID = ?");

                    $stmt->execute(array($freq, $cost, $servcost, $id));

                    $rowscount = $stmt->rowCount();

                }

                echo "<div class='container'><div class='text-center alert alert-success'>تم التعديل بنجاح</div></div>";




              } else {

                $count = (count($_POST) / 3);

                for($i = 1;$i <= $count;$i = $i + 1){

                    $id   = filter_var($_POST['ID' . $i], FILTER_VALIDATE_FLOAT);

                    $freq = filter_var($_POST['freq' . $i], FILTER_VALIDATE_FLOAT);

                    $cost = filter_var($_POST['cost' . $i], FILTER_VALIDATE_FLOAT);

                    $stmt = $con->prepare("UPDATE summ SET
                          freq = ?, cost = ? WHERE ID = ?");

                    $stmt->execute(array($freq, $cost, $id));

                    $rowscount = $stmt->rowCount();

                }

                echo "<div class='container'><div class='text-center alert alert-success'>تم التعديل بنجاح</div></div>";

              }

              header("refresh: 3; url = summ.php?do=mange");

            }

          }

        include $tmp . 'footer.php';

    } else {

      header('Location: index.php');

      exite();

    }

  } else {

    header('Location: index.php');

    exite();

  }

?>
