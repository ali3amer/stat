<?php
session_start();
$pageTitle = 'تقرير مركز';
if(isset($_SESSION['centeruser'])) {

    $nonavbar = '';

    if(isset($_SESSION['center'])) {

        include 'init.php';

        $namecenter = getOne('name', 'center', 'WHERE ID = ' . $_SESSION['center'], '', 'ID', '');

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
            '14'  =>  '14/تفاصيل الإحالة على خدمة الإختصاصيين خارج الولاية'

        );

            $date = $_SESSION['month'];

            $one  = checkrow('DISTINCT(tnum)', 'summ', "WHERE daate = '$date' ", 'AND center = ' . $_SESSION['center'], 'ID', '');
            $two  = checkrow('DISTINCT(tnum)', 'summt', "WHERE daate = '$date' ", 'AND center = ' . $_SESSION['center'], 'ID', '');
            $three  = checkrow('DISTINCT(tnum)', 'freq', "WHERE daate = '$date' ", 'AND center = ' . $_SESSION['center'], 'ID', '');

            if(($one + $two + $three) > 10) {
                ?>

                <div class="report">
                    بسم الله الرحمن الرحيم <br />
                    الصندوق القومي للتأمين الصحي <br />
                    إدارة التخطيط <br />
                    قسم الإحصاء <br />
                    <?php echo 'تقرير ' . $namecenter['name'] . ' لشهر : ' . $date; ?>
                </div>


                <div class="container reports">

                    <?php
                    $checkreport = 0;
                    for ($j = 1; $j <= 14; $j++) {

                        if($j == 3) {

                            $rows = getAllFrom('summt.*, tables.name as name', 'summt', 'INNER JOIN tables ON tables.ID = summt.nameid WHERE summt.tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'], 'ID', '');

                        }elseif($j == 4 || $j == 13) {

                            $rows = getAllFrom('freq.*, tables.name as name', 'freq', 'INNER JOIN tables ON tables.ID = freq.nameid WHERE freq.tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'], 'ID', '');

                        } else {

                            $rows = getAllFrom('summ.*, tables.name as name', 'summ', 'INNER JOIN tables ON tables.ID = summ.nameid WHERE summ.tnum = ' . $j, "AND daate = '$date' AND center = " . $_SESSION['center'], 'ID', '');

                        }

                        if($rows != null) { ?>

                            <div class="tables-section <?php if($j != 1){echo "breakpage";} ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered">

                                        <?php

                                        if($j == 1){ ?>

                                            <tr>
                                                <th colspan="<?php echo count($rows) + 2; ?>"><?php echo $arrayTable[$j]; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">البيان</th>
                                                <th colspan="<?php echo count($rows); ?>">الفــــــــــئات العمريه</th>
                                                <th rowspan="2">المجموع</th>
                                            </tr>
                                            <tr>
                                                <?php foreach($rows as $row):?>
                                                    <th>
                                                        <?php echo $row['name']; ?>
                                                    </th>
                                                <?php endforeach;?>

                                            </tr>
                                            <tr>
                                                <th>ذكر</th>
                                                <?php $total = 0; foreach($rows as $row):?>
                                                    <td><?php $total += $row['freq']; echo $row['freq']; ?></td>
                                                <?php endforeach;?>
                                                <td><?php echo $total; ?></td>
                                            </tr>
                                            <tr>
                                                <th>إنثى</th>
                                                <?php $total = 0; foreach($rows as $row):?>
                                                    <td><?php $total += $row['cost']; echo $row['cost']; ?></td>
                                                <?php endforeach;?>
                                                <td><?php echo $total; ?></td>
                                            </tr>
                                            <tr>
                                                <th>المجموع</th>
                                                <?php $total = 0; foreach($rows as $row):?>
                                                    <td><?php $total += $row['freq'] + $row['cost']; echo $row['freq'] + $row['cost']; ?></td>
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
                                            <?php $freq = 0;$cost = 0;$servcost = 0;$jobcost = 0; foreach($rows as $row):?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $freq += $row['freq'];$cost += round($row['cost'], 2);$servcost += round($row['servcost'], 2);$jobcost += round($row['jobcost'], 2);

                                                        echo $row['name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['freq']; ?></td>
                                                    <td><?php echo round($row['cost'], 2); ?></td>
                                                    <td><?php echo round($row['servcost'], 2); ?></td>
                                                    <td><?php echo round($row['jobcost'], 2); ?></td>
                                                    <td><?php echo round(($row['cost'] + $row['servcost'] + $row['jobcost']), 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                            <tr>
                                                <th>الجمله</th>
                                                <th><?php echo $freq; ?></th>
                                                <th><?php echo $cost; ?></th>
                                                <th><?php echo $servcost; ?></th>
                                                <th><?php echo $jobcost; ?></th>
                                                <th><?php echo round(($cost + $servcost + $jobcost), 2); ?></th>
                                            </tr>

                                            <?php
                                        } elseif($j == 4) {  ?>

                                            <tr>
                                                <th colspan="2"><?php echo $arrayTable[$j]; ?></th>
                                            </tr>
                                            <tr>
                                                <th>المرض</th>
                                                <th>التردد</th>
                                            </tr>
                                            <?php $total = 0; foreach($rows as $row): $total += $row['freq']; ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo $row['name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['freq']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                            <tr>
                                                <th>الجمله</th>
                                                <th><?php echo $total; ?></th>
                                            </tr>

                                            <?php
                                        } elseif($j == 5) { ?>

                                            <tr>
                                                <th colspan="<?php echo count($rows) + 2; ?>"><?php echo $arrayTable[$j]; ?></th>
                                            </tr>
                                            <tr>
                                                <th>المرض</th>
                                                <?php foreach($rows as $row):?>
                                                    <th>
                                                        <?php echo $row['name']; ?>
                                                    </th>
                                                <?php endforeach;?>
                                                <th>المجموع</th>
                                            </tr>
                                            <tr>
                                                <th>التردد</th>
                                                <?php $total = 0; foreach($rows as $row):?>
                                                    <td><?php $total += $row['freq']; echo $row['freq']; ?></td>
                                                <?php endforeach;?>
                                                <th><?php echo $total; $freqill = $total; ?></th>
                                            </tr>
                                            <tr>
                                                <th>التكلفة</th>
                                                <?php $total = 0; foreach($rows as $row):?>
                                                    <td><?php $total += round($row['cost'], 2); echo round($row['cost'], 2); ?></td>
                                                <?php endforeach;?>
                                                <th><?php echo $total; $costill = $total; ?></th>
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
                                            <?php $i = 1; ?>
                                            <?php foreach($rows as $row): ?>
                                                <tr>
                                                    <td>
                                                        <?php

                                                        echo $row['name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['freq']; ?></td>
                                                    <td><?php echo round($row['cost'], 2); ?></td>
                                                    <td><?php if($row['freq'] == 0) {echo 0;} else {echo round(round($row['cost'], 2) / $row['freq'], 2);} ?></td>
                                                </tr>
                                                <?php $i = $i + 1; ?>
                                            <?php endforeach; ?>

                                            <?php
                                        } elseif($j == 13) { ?>
                                            <tr>
                                                <th colspan="<?php echo count($rows) + 4; ?>"><?php echo $arrayTable[$j]; ?></th>
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
                                                <?php foreach($rows as $row):?>
                                                    <th>
                                                        <?php echo $row['name']; ?>
                                                    </th>
                                                <?php endforeach;?>
                                            </tr>
                                            <tr>
                                                <td><?php if(isset($totalfreq)) { echo $totalfreq; } ?></td>
                                                <td><?php if(isset($totalcost)) { echo $totalcost; } ?></td>
                                                <td><?php if(isset($freqill)) { echo $freqill; } ?></td>
                                                <td><?php if(isset($costill)) { echo $costill; } ?></td>
                                                <?php foreach($rows as $row):?>
                                                    <td><?php echo round($row['freq'], 2); ?></td>
                                                <?php endforeach;?>
                                            </tr>

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
                                            <?php $freq = 0; $cost = 0; foreach($rows as $row): 
                                                
                                            if($row['name'] != $_SESSION['statename']) {    
                                                
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php

                                                        $freq += $row['freq'];
                                                        $cost += round($row['cost'], 2);

                                                        echo $row['name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['freq']; ?></td>
                                                    <td><?php echo round($row['cost'], 2); ?></td>
                                                </tr>
                                                <?php $i = $i + 1; ?>
                                            <?php } endforeach; ?>
                                            <tr>
                                                <th>الجمله</th>
                                                <th><?php echo $freq; if($j == 2) { $totalfreq = $freq; } ?></th>
                                                <th><?php echo $cost; if($j == 2) { $totalcost = $cost; } ?></th>
                                            </tr>
                                            <?php
                                        } ?>
                                    </table>
                                </div>
                            </div>

                            <?php
                        } else {
                            $checkreport++;

                            if($checkreport > 12) { ?>

                                <div style="margin-top: 50px" class="container alert alert-danger">
                                    <ul>
                                        <li>عفواً هذا التقرير لم يتم إعداده بعد</li>
                                    </ul>
                                </div>

                                <?php
                            }
                        }

                    } ?>

                </div>
                <?php


        include $tmp . 'footer.php';
                } else{ ?>

                                <div style="margin-top: 50px" class="container alert alert-danger">
                                    <ul>
                                        <li>عفواً هذا التقرير لم يتم إعداده بعد</li>
                                    </ul>
                                </div>

                                <?php
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
