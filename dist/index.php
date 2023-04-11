<!-- <?php
date_default_timezone_set("Africa/Tunis");
error_reporting(0);
?> -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard TTEI by Advantry X</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <?php require_once './config.php';
        if (isset($_GET["prod_line"]) || isset ($_GET["prod"])) {
              $prodline=$_GET["prod_line"];
              //$prod=$_GET["prod"];
        ?>




        <!-- <script>
            function autoRefresh() {
                window.location = window.location.href="http://localhost/TTEI/dist/index.php?prod_line=<?php //echo($prod);?>&prod=<?php //echo($prodline);?>";
            }
            setInterval('autoRefresh()', 60000);
        </script> -->


        <script>
            function autoRefresh() {
                window.location = window.location.href="http://localhost/TTEI/dist/index.php?prod_line=F56";
            }
            setInterval(autoRefresh, 10000);
        </script>

    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-indigo">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="http://advantryx.com/"> <img src="img/logo.png" alt="Logo" style="width:40mm;height:15mm"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></button>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="prodline"> Prod-Line:
                        <?php echo ($prodline);}?> </h4></div>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="date"> DATE: <?php echo date('d/m/Y');?> </h4></div>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="time"> HEURE: <?php echo (date('H:i'));?> </h4></div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- <h1 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo"> TTEI </h1> -->
                <div class = ""> <img src="img/OneTechLogo.png" alt="Logo" style="width:40mm;height:40mm;margin-left:30mm"></div>
                </div>
            </div>
        </nav>
        <div class="py-4"></div>
        <!-- Page Content-->
        <section class="pt-4">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5">
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/prog.svg" alt="icone"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Référence Encours</h2>
                                <div id="qteEng" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php



                                $sql1="SELECT * FROM `prod__control` WHERE `prod_line`='$prodline'";
                                $rslt1=$con->query($sql1);

                                $control=[];

                                while ($item = $rslt1->fetch_assoc())
                                {
                                    $control[] = $item;
                                }

                                $reference = $control[count($control)-1]['reference'];

                                echo($reference)
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/good.svg" alt="icone"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Quantité OK</h2>
                                <div id="qteProg" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php

                               $t=time();  $OK=1; $NOK=1; $tab=[];
                               if(($t>strtotime("06:00:00"))&($t<strtotime("14:00:00"))){
                                //    echo("1st shift");
                                   $query1 = "SELECT SUM(OK) AS OK, SUM(NOK) AS NOK FROM `prod__control`
                                   WHERE `prod__control`.`cur_time` >= '06:00:00'
                                   AND  `prod__control`.`cur_time` <= '14:00:00'
                                   AND `prod__control`.`cur_date` = DATE_FORMAT(CURRENT_DATE,'%Y/%m/%d')";

                                   $rslt1=$con->query($query1);
                                   while ($item = $rslt1->fetch_assoc()){ $tab[] = $item; };
                                   $OK+=$tab[count($tab)-1]['OK'];
                                   $NOK+=$tab[count($tab)-1]['NOK'];

                                  }

                              elseif(($t>strtotime("14:00:00"))&($t<strtotime("22:00:00"))){
                                //    echo("2nd shift");
                                   $query2 = "SELECT SUM(OK) AS OK, SUM(NOK) AS NOK FROM `prod__control`
                                   WHERE `prod__control`.`cur_time` >= '14:00:00'
                                   AND  `prod__control`.`cur_time` <= '22:00:00'
                                   AND `prod__control`.`cur_date` = DATE_FORMAT(CURRENT_DATE, '%Y/%m/%d')";

                                   $rslt2=$con->query($query2);

                                   while ($item = $rslt2->fetch_assoc()){ $tab[] = $item; };
                                   $OK+=$tab[count($tab)-1]['OK'];
                                   $NOK+=$tab[count($tab)-1]['NOK'];
                                  }

                               elseif(($t>strtotime("22:00:00"))&($t<strtotime("23:59:59"))){
                                //    echo("3rd shift");
                                   $query3 = "SELECT SUM(OK) AS OK, SUM(NOK) AS NOK FROM `prod__control`
                                   WHERE `prod__control`.`cur_time` >= '22:00:00'
                                   AND `prod__control`.`cur_date` = DATE_FORMAT(CURRENT_DATE,'%Y/%m/%d')";

                                   $rslt3=$con->query($query3);

                                   while ($item = $rslt3->fetch_assoc()){ $tab[] = $item; };
                                   $OK+=$tab[count($tab)-1]['OK'];
                                   $NOK+=$tab[count($tab)-1]['NOK'];
                                  }

                               elseif(($t>strtotime("00:00:00"))&($t<strtotime("06:00:00"))){
                                //    echo("3rd shift");
                                   $query4 = "SELECT SUM(OK) AS OK, SUM(NOK) AS NOK FROM `prod__control`
                                   WHERE `cur_date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY)
                                   AND `cur_time` >='22:00:00'";


                                   $rslt4=$con->query($query4);

                                   while ($item = $rslt4->fetch_assoc()){ $tab[] = $item; };
                                   (int) $OK1=$tab[count($tab)-1]['OK'];
                                   (int) $NOK1=$tab[count($tab)-1]['NOK'];

                                   $query5 = "SELECT SUM(OK) AS OK, SUM(NOK) AS NOK FROM `prod__control`
                                   WHERE `prod__control`.`cur_time` >= '00:00:00'
                                   AND  `prod__control`.`cur_time` < '06:00:00'
                                   AND `prod__control`.`cur_date` = DATE_FORMAT(CURRENT_DATE,'%Y/%m/%d')";

                                   $rslt5=$con->query($query5);

                                   while ($item = $rslt5->fetch_assoc()){ $tab[] = $item; };
                                   $OK2=$tab[count($tab)-1]['OK'];
                                   $NOK2=$tab[count($tab)-1]['NOK'];

                                   (int) $OK+=$OK1+$OK2;
                                   (int) $NOK+=$NOK1+$NOK2;

                                  }
                                echo($OK-1)

                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/bad.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Quantité NOK</h2>
                                <div id="qteFab" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php

                                echo ($NOK-1);
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/settings.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Productivité</h2>
                                <div id="prod" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php


                                // $query1 = "SELECT * FROM `prod__presence` WHERE p_state= 'in' ORDER BY matricule";
                                // $query2 = "SELECT * FROM `prod__presence` WHERE p_state= 'out' ORDER BY matricule";
                                // $query3 = "SELECT t1.reference, t1.OK, t2.DMH FROM `prod__control` AS t1
                                // INNER JOIN `prod__product` AS t2
                                // ON t1.reference = t2.reference
                                // WHERE prod_line = '$prodline'";
                                // $query4 = "SELECT * FROM `prod__presence` WHERE p_state = 'in'";
                                // $query5 = "SELECT * FROM `prod__presence` WHERE p_state = 'out'";

                                // $rslt1=$con->query($query1);
                                // $rslt2=$con->query($query2);
                                // $rslt3=$con->query($query3);
                                // $rslt4=$con->query($query4);
                                // $rslt5=$con->query($query5);

                                // $time_in=[];
                                // $time_out=[];
                                // $QTE=[];
                                // $presence_in=[];
                                // $presence_out=[];

                                // while ($item = $rslt1->fetch_assoc())
                                // {
                                //     $time_in[] = $item;
                                // };


                                // while ($item = $rslt2->fetch_assoc())
                                // {
                                //     $time_out[] = $item;
                                // };

                                // while ($item = $rslt3->fetch_assoc())
                                // {
                                //     $QTE[] = $item;
                                // };

                                // $interval=0;
                                // $prod_qte=0;

                                // for($i=0; $i<count($time_out); $i++){
                                //    $interval += (strtotime("now") - strtotime($time_in[$i]['cur_time']));
                                // };
                                // // $time=round($interval/3600,2);

                                // for($i=0; $i<count($QTE); $i++){
                                //     $prod_qte += (($QTE[$i]['OK']) * ($QTE[$i]['DMH']) * 0.36);
                                //  };

                                //  while ($item = $rslt4->fetch_assoc())
                                //  {
                                //      $presence_in[] = $item;
                                //  };


                                //  while ($item = $rslt5->fetch_assoc())
                                //  {
                                //      $presence_out[] = $item;
                                //  };

                                //  $presence = count($presence_in) - count($presence_out);

                                //  $productivity= $prod_qte/($presence*$interval);

                                 //echo(round($productivity,2))
                                ?> - </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/activity.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">PPM</h2>
                                <div id="ppm" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                if (($NOK-1) == 0){
                                    echo(0);
                                }  else {
                                    echo(round((($NOK-1)/($OK-1+$NOK-1)),2));
                                }
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/clock.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Présence</h2>
                                <div id="npt" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php


                                $t=time();  $presence_in=0; $presence_out=0; $presence=0; $tab=[]; $tab5=[];
                                if(($t>strtotime("06:00:00"))&($t<strtotime("14:00:00"))){
                                 //    echo("1st shift");
                                    $query1 = "SELECT p_state, COUNT(p_state) AS p_count, cur_date, matricule
                                    FROM `prod__presence`
                                    WHERE `prod__presence`.`cur_date` = CURDATE()
                                    AND `prod__presence`.`cur_time` >= '06:00:00'  AND `prod__presence`.`cur_time` < '14:00:00'
                                    GROUP BY p_state;";

                                    $rslt1=$con->query($query1);
                                    while ($item = $rslt1->fetch_assoc()){ $tab[] = $item; };

                                        (int) $presence_in=(int) $tab[0]['p_count'];
                                        (int) $presence_out=(int) $tab[1]['p_count'];

                                    (int) $presence = $presence_in - $presence_out;

                                   }

                               elseif(($t>strtotime("14:00:00"))&($t<strtotime("22:00:00"))){
                                 //    echo("2nd shift");
                                    $query2 = "SELECT p_state, COUNT(p_state) AS p_count
                                    FROM `prod__presence`
                                    WHERE cur_date = CURDATE() AND `prod__presence`.`cur_time` >= '14:00:00'
                                    AND `prod__presence`.`cur_time` < '22:00:00'
                                    GROUP BY p_state";

                                    $rslt2=$con->query($query2);

                                    while ($item = $rslt2->fetch_assoc()){ $tab[] = $item; };

                                    (int) $presence_in=(int) $tab[0]['p_count'];
                                    (int) $presence_out=(int) $tab[1]['p_count'];

                                (int) $presence = $presence_in - $presence_out;
                                   }

                                elseif(($t>strtotime("22:00:00"))&($t<strtotime("23:59:59"))){
                                    // echo("3rd shift");
                                    $query3 = "SELECT COUNT(p_state) AS p_count
                                    FROM `prod__presence`
                                    WHERE cur_date = CURDATE() AND `prod__presence`.`cur_time` >= '22:00:00'
                                    GROUP BY p_state";

                                    $rslt3=$con->query($query3);  $presence_in=0; $presence_out=0;

                                    while ($item = $rslt3->fetch_assoc()){ $tab[] = $item; };

                                    (int) $presence_in=(int) $tab[0]['p_count'];
                                    (int) $presence_out=(int) $tab[1]['p_count'];

                                (int) $presence = $presence_in - $presence_out;
                                   }

                                elseif(($t>strtotime("00:00:00"))&($t<strtotime("06:00:00"))){
                                 //    echo("3rd shift");
                                    $query4 = "SELECT  COUNT(p_state) AS p_count
                                    FROM `prod__presence` WHERE cur_date = DATE_ADD(CURDATE(), INTERVAL -1 DAY)
                                    AND `prod__presence`.`cur_time` >= '22:00:00'
                                    GROUP BY p_state";


                                    $rslt4=$con->query($query4);

                                    while ($item = $rslt4->fetch_assoc()){ $tab[] = $item; };

                                       (int) $presence_in1=(int) $tab[0]['p_count'];
                                        (int) $presence_out1=(int) $tab[1]['p_count'];



                                    $query5 = "SELECT  COUNT(p_state) AS p_count
                                    FROM `prod__presence`
                                    WHERE cur_date = CURDATE() AND `prod__presence`.`cur_time` <= '06:00:00'
                                    GROUP BY p_state";

                                    $rslt5=$con->query($query5);

                                    while ($item = $rslt5->fetch_assoc()){ $tab5[] = $item; };

                                    (int) $presence_in2= (int) $tab5[0]['p_count'];
                                    (int) $presence_out2=(int) $tab5[1]['p_count'];



                                    (int) $presence_in=$presence_in1+$presence_in2;
                                    (int) $presence_out=$presence_out1+$presence_out2;

                                    (int) $presence =  $presence_in - $presence_out;

                                   }


                                    echo($presence);


                                ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="container"><p class="m-0 text-center text-indigo">Copyright &copy; Advantry X 2023</p>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
