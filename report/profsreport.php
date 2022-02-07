<?php
session_start();
if(isset($_SESSION['admin']) || isset($_SESSION['mreports'])) {
    $nonavbar = '';
    include 'init.php';


    $month = $_SESSION['month'];

    $visits = getAllFrom('ID', 'visit', "WHERE vmonth = '$month'", '', 'ID', '');

    if($visits != null){ ?>

    <div class="container" style ="margin-top:50px;">
    <div class="table-responsive">
        <table class="table table-bordered">
        <tr>
            <th>الإسم</th>
            <th>التردد</th>
            <th>التكلفه</th>
        </tr>


    <?php

    $profsname = getAllFrom('ID, name', 'profsname', "", '', 'ID', '');

    foreach($profsname as $profname):

        $cost = 0; $freq = 0;

        foreach($visits as $visit):

        

            $prof = getOne('COUNT(ID) as counts, SUM(cost) as sumprof', 'prof', "WHERE visit = " . $visit['ID'], " AND profname = " . $profname['ID'], 'ID', '');
            if($prof['counts'] != 0) { 
                            
                $cost += $prof['sumprof'] ;
                $freq++;

            }

        endforeach;

            ?>

            <tr>
                <td><?php echo $profname['name'] ?></td>
                <td><?php echo $freq ?></td>
                <td><?php echo $cost; ?></td>
            </tr>


        <?php
        

    endforeach; ?>

        </table>
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
