<?php
  session_start();
  if(isset($_SESSION['centeruser']) && isset($_SESSION['center'])) {

      include 'init.php';
      $daate = $_SESSION['month'];

      /// --------------------- TABLE 1 ---------------------------------------------------------//
      $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 1' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

      if($summ == null) {

        $names = getAllFrom('*', 'tables', 'WHERE tnum = 1', '', 'ID', '');
        $visits = getAllFrom('ID, client', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');

          foreach($visits as $visit) {
            $clients[] = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], '', 'ID', '');
          }

          foreach($names as $name) {
            $freq = 0; $cost = 0;
            foreach($clients as $client) {
              if($name['ID'] == $client['age']) {
                if($client['gender'] == 1) {
                  $freq ++;
                } elseif($client['gender'] == 2) {
                  $cost ++;
                }
              }
            }
            insertData(1, $name['ID'], $freq, $cost, $daate);
         }

      }


       /// --------------------- TABLE 1 ---------------------------------------------------------//
                              /******************
                              ******************
                              ******************
                              ******************/
       /// --------------------- TABLE 2 ---------------------------------------------------------//



        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 2' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 2', '', 'ID', '');
          $visits = getAllFrom('ID, client', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $client = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], '', 'ID', '');

                if($name['ID'] == $client['sector']) {
                  $freq ++;
                  $check = getOne('sum(cost) as summ', 'checks', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $defrent = getOne('sum(cost) as summ', 'defrent', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $eyes = getOne('sum(cost) as summ', 'eyes', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $ills = getOne('sum(cost) as summ', 'ills', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $meet = getOne('sum(cost) as summ', 'meet', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $sugar = getOne('sum(cost) as summ', 'suger', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $medcin = getOne('sum(cost) as summ', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $prof = getOne('sum(cost) as summ', 'prof', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  
                  if($check['summ'] != null) {
                    $cost += $check['summ'];
                  }
                  if($defrent['summ'] != null) {
                    $cost += $defrent['summ'];
                  }
                  if($eyes['summ'] != null) {
                    $cost += $eyes['summ'];
                  }
                  if($ills['summ'] != null) {
                    $cost += $ills['summ'];
                  }
                  if($meet['summ'] != null) {
                    $cost += $meet['summ'];
                  }
                  if($sugar['summ'] != null) {
                    $cost += $sugar['summ'];
                  }
                  if($medcin['summ'] != null) {
                    $cost += $medcin['summ'];
                  }
                  if($prof['summ'] != null) {
                    $cost += $prof['summ'];
                  }
                }

              }
              insertData(2, $name['ID'], $freq, $cost, $daate);
           }
          }

        }



       /// --------------------- TABLE 2 ---------------------------------------------------------//
                              /******************
                              ******************
                              ******************
                              ******************/
       /// --------------------- TABLE 3 ---------------------------------------------------------//

       $summ = getAllFrom('ID', 'summt', 'WHERE tnum = 3' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

       if($summ == null) {

         $names = getAllFrom('*', 'tables', 'WHERE tnum = 3', '', 'ID', '');
         $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
         if($visits != null) {
           foreach($names as $name) {
             $freq = 0; $cost = 0; $servcost = 0; $jobcost = 0;
             foreach($visits as $visit) {
               $eyes = getAllFrom('*', 'eyes', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
               foreach($eyes as $eye):
               if($name['ID'] == $eye['eye']) {
                  $freq ++; $cost += $eye['cost']; $servcost += $eye['servcost']; $jobcost += $eye['jobcost'];
               }
             endforeach;
             }
             insertSummt(3, $name['ID'], $freq, $cost, $servcost, $jobcost, $daate);
          }
        }

       }


        /// --------------------- TABLE 3 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 4 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'freq', 'WHERE tnum = 4' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 4', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0;
              foreach($visits as $visit) {
                $defrents = getAllFrom('*', 'defrent', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($defrents as $defrent):
                if($name['ID'] == $defrent['defrent']) {
                   $freq ++;
                }
              endforeach;
              }
              insertFreq(4, $name['ID'], $freq, $daate);
           }
          }

        }


        /// --------------------- TABLE 4 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 5 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 5' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 5', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $ills = getAllFrom('*', 'ills', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($ills as $ill):
                if($name['ID'] == $ill['ill']) {
                   $freq ++; $cost += $ill['cost'];
                }
              endforeach;
              }
              insertData(5, $name['ID'], $freq, $cost, $daate);
           }
          }

        }


        /// --------------------- TABLE 5 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 6 ---------------------------------------------------------//

        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 6' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 6', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $sugers = getAllFrom('*', 'suger', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($sugers as $suger):
                if($name['ID'] == $suger['suger']) {
                   $freq ++; $cost += $suger['cost'];
                }
              endforeach;
              }
              insertData(6, $name['ID'], $freq, $cost, $daate);
           }
          }

        }

        /// --------------------- TABLE 6 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 7 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 7' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 7', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $meets = getAllFrom('*', 'meet', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($meets as $meet):
                if($name['ID'] == $meet['meet']) {
                   $freq ++; $cost += $meet['cost'];
                }
              endforeach;
              }
              insertData(7, $name['ID'], $freq, $cost, $daate);
           }
          }

        }

        /// --------------------- TABLE 7 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 8 ---------------------------------------------------------//






        /// --------------------- TABLE 8 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 9 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 9' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 9', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $proccess = getAllFrom('*', 'proccess', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($proccess as $procces):
                if($name['ID'] == $procces['procces']) {
                   $freq ++; $cost += $procces['cost'];
                }
              endforeach;
              }
              insertData(9, $name['ID'], $freq, $cost, $daate);
           }
          }

        }



        /// --------------------- TABLE 9 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 10 ---------------------------------------------------------//

        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 10' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 10', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $checks = getAllFrom('*', 'checks', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($checks as $check):
                if($name['ID'] == $check['checks']) {
                   $freq ++; $cost += $check['cost'];
                }
              endforeach;
              }
              insertData(10, $name['ID'], $freq, $cost, $daate);
           }
          }

        }

        /// --------------------- TABLE 10 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 11 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 11' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 11', '', 'ID', '');
          $visits = getAllFrom('ID, client', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $client = getOne('*', 'client', 'WHERE ID = ' . $visit['client'], '', 'ID', '');

                if($name['ID'] == $client['cardstate']) {
                  $freq ++;
                  $check = getOne('sum(cost) as summ', 'checks', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $defrent = getOne('sum(cost) as summ', 'defrent', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $eyes = getOne('sum(cost) as summ', 'eyes', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $ills = getOne('sum(cost) as summ', 'ills', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $meet = getOne('sum(cost) as summ', 'meet', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $sugar = getOne('sum(cost) as summ', 'suger', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $medcin = getOne('sum(cost) as summ', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  $prof = getOne('sum(cost) as summ', 'prof', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                  
                  if($check['summ'] != null) {
                    $cost += $check['summ'];
                  }
                  if($defrent['summ'] != null) {
                    $cost += $defrent['summ'];
                  }
                  if($eyes['summ'] != null) {
                    $cost += $eyes['summ'];
                  }
                  if($ills['summ'] != null) {
                    $cost += $ills['summ'];
                  }
                  if($meet['summ'] != null) {
                    $cost += $meet['summ'];
                  }
                  if($sugar['summ'] != null) {
                    $cost += $sugar['summ'];
                  }
                  if($medcin['summ'] != null) {
                    $cost += $medcin['summ'];
                  }
                  if($prof['summ'] != null) {
                    $cost += $prof['summ'];
                  }
                }

              }
              insertData(11, $name['ID'], $freq, $cost, $daate);
           }
          }

        }


        /// --------------------- TABLE 11 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 12 ---------------------------------------------------------//


        $summ = getAllFrom('ID', 'summ', 'WHERE tnum = 12' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 12', '', 'ID', '');
          $visits = getAllFrom('ID', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
            foreach($names as $name) {
              $freq = 0; $cost = 0;
              foreach($visits as $visit) {
                $profs = getAllFrom('*', 'prof', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                foreach($profs as $prof):
                if($name['ID'] == $prof['prof']) {
                   $freq ++; $cost += $prof['cost'];
                }
              endforeach;
              }
              insertData(12, $name['ID'], $freq, $cost, $daate);
           }
          }

        }


        /// --------------------- TABLE 12 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- TABLE 13 ---------------------------------------------------------//



        $summ = getAllFrom('ID', 'freq', 'WHERE tnum = 13 AND nameid != 103 ' . ' AND center = ' . $_SESSION['center'], " AND daate = '$daate' ", 'ID', '');

        if($summ == null) {

          $names = getAllFrom('*', 'tables', 'WHERE tnum = 13', '', 'ID', '');
          $visits = getAllFrom('ID, daay', 'visit', 'WHERE center = ' . $_SESSION['center'], " AND vmonth = '$daate' ", 'ID', '');
          if($visits != null) {
              $medcinfreq = 0; $cost = 0; $nightfreq = 0; $morningfreq = 0;
              
              foreach($visits as $visit) {
                $medcins = getAllFrom('*', 'medcin', 'WHERE visit = ' . $visit['ID'], '', 'ID', '');
                if($visit['daay'] == 1) {
                  $morningfreq ++;
                } elseif($visit['daay'] == 2) {
                  $nightfreq ++;
                }
                if($medcin != null) {
                  foreach($medcins as $medcin) {
                    $medcinfreq ++;
                    $cost += $medcin['cost'];
                  }
                }
              }
                
              insertFreq(13, 98, $medcinfreq, $daate);
              insertFreq(13, 99, $cost, $daate);
              insertFreq(13, 101, $morningfreq, $daate);
              insertFreq(13, 102, $nightfreq, $daate);
          }

        }


        /// --------------------- TABLE 13 ---------------------------------------------------------//
                               /******************
                               ******************
                               ******************
                               ******************/
        /// --------------------- THE END  -------------------------------------------------------//

      ?>

      <?php
      header("Location: unnhif.php");

    include $tmp . 'footer.php';

} else {

  header('Location: index.php');
  exite();

}

?>