<?php
date_default_timezone_set("Africa/Tunis");
error_reporting(0);
?>
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
if (isset($_GET["prod_line"]) || isset($_GET["prod"])) {
    $prodline = $_GET["prod_line"];
    //$prod=$_GET["prod"];
?>
    <script>
        function autoRefresh() {
            //window.location = window.location.href = "http://10.33.8.18/TTEI/dist/index.php?prod_line=F56";
            //window.location = window.location.href = "http://192.168.201.19/TTEI/dist/index.php?prod_line=F56";
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
                <div class="collapse navbar-collapse">
                    <h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="prodline"> Prod-Line:
                    <?php echo ($prodline);
                } ?> </h4>
                </div>
                <div class="collapse navbar-collapse">
                    <h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="date"> DATE: <?php echo date('d/m/Y'); ?> </h4>
                </div>
                <div class="collapse navbar-collapse">
                    <h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="time"> HEURE: <?php echo (date('H:i')); ?> </h4>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand" href="https://onetech-group.com/"> <img src="img/OneTechLogo.png" alt="Logo" style="width:40mm;height:40mm;margin-left:30mm"></a>
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
                                    $sql1 = "SELECT * FROM `prod__control` WHERE `prod_line`='$prodline' ";
                                    $rslt1 = $con->query($sql1);

                                    $control = [];

                                    while ($item = $rslt1->fetch_assoc()) {
                                        $control[] = $item;
                                    }

                                    $reference = $control[count($control) - 1]['reference'];
                                    $of = $control[count($control) - 1]['OF'];
                                    echo ($reference)
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

                                    $t = time();
                                    $OK = 0;
                                    $NOK = 0;
                                    $tab = [];
                                    $item=[];
                                    $item1=[];
                                    $shift =0;

                                    $sql="SELECT `prod_line`,
                                                `shift_duration`
                                            FROM `init__prod_line`
                                            WHERE `prod_line` ='$prodline'";
                                    $rslt = $con->query($sql);
                                    $item = $rslt->fetch_assoc();
                                    $shift = $item['shift_duration'];
                                    $shift = (int)$shift + 1 ;
                                    // echo $shift ;

                                    $sql1="SELECT
                                    CAST(
                                        CONCAT(
                                            `prod__presence`.`cur_date`,
                                            ' ',
                                            `prod__presence`.`cur_time`
                                        ) AS DATETIME
                                    ) AS 'start_shift'
                                FROM
                                    `prod__presence`
                                WHERE
                                    `id` IN(
                                    SELECT
                                        MAX(`id`)
                                    FROM
                                        `prod__presence`
                                    GROUP BY
                                        `matricule`
                                ) AND `p_state` = 'in' AND `prod_line` = '$prodline' AND CAST(
                                    CAST(
                                        HOUR(
                                            TIMEDIFF(
                                                CURRENT_DATE,
                                                `prod__presence`.`cur_date`
                                            )
                                        ) AS SIGNED
                                    ) + CAST(
                                        HOUR(
                                            TIMEDIFF(
                                                CURRENT_TIME,
                                                `prod__presence`.`cur_time`
                                            )
                                        ) AS SIGNED
                                    ) AS SIGNED
                                ) < ($shift+1)
                                ORDER BY
                                    `id` ASC
                                LIMIT 1;";
                                $rslt1 = $con->query($sql1);
                                $item1 = $rslt1->fetch_assoc();
                                $start_shift = $item1['start_shift'];
                                if ( $start_shift != NULL) {
                                    $flag=1;
                                } else {$flag =0 ; }
                                //echo 'S_S'.$start_shift;
                                if($flag=0){
                                    $OK=0;
                                    $NOK=0;
                                }
                                    else {
                                        $query1 = "SELECT `prod_line`,
                                        SUM(`OK`) AS 'OK',
                                        SUM(`NOK`) AS 'NOK'
                                    FROM `prod__control`
                                    WHERE `prod_line` = '$prodline'
                                        AND CAST(
                                            CONCAT(
                                                `prod__control`.`cur_date`,
                                                ' ',
                                                `prod__control`.`cur_time`
                                            ) AS DATETIME
                                        ) >= '$start_shift' ";

                                        $rslt1 = $con->query($query1);
                                        while ($item = $rslt1->fetch_assoc()) {
                                            $tab[] = $item;
                                        };
                                        for ($i = 0; $i < count($tab); $i++) {
                                            $OK += $tab[$i]['OK'];
                                            $NOK += $tab[$i]['NOK'];
                                        }
                                    }
                                     echo ($OK);
                                    ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/bad.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Quantité NOK</h2>
                                <div id="qteFab" class="h2 mb-2 font-weight-bold text--bs-gray-900">
                                    <?php
                                    echo ($NOK);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/settings.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Productivité</h2>
                                <div id="prod" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                if ($flag=0){
                                    $production=0;
                                } else {
                                 $query2 = "SELECT * FROM `prod__productivity` WHERE `prod_line` LIKE '$prodline' ORDER BY `id` DESC LIMIT 1";

                                 $rslt2 = $con->query($query2);
                                 $tab2=[];
                                 while ($item = $rslt2->fetch_assoc()) {
                                     $tab2[] = $item;
                                 };
                                 if(count($tab2)!=0){
                                    $production= $tab2[0]['productivity'];
                                    echo $production;
                                 }else {
                                    echo 0 ;
                                 }
                                }
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/activity.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">PPM</h2>
                                <div id="ppm" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                if (($NOK) != 0) {
                                    $ppm= (round((($NOK) * 1000000 / ($OK + $NOK)), 2));
                                    echo $ppm ;
                                } else {
                                    echo (0);
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
                                <div id="npt" class="h2 mb-2 font-weight-bold text--bs-gray-900">
                                    <?php $t = time();
                                    $presence = 0;
                                    $tab = [];
                                    $tab5 = [];
                                    $query1 ="SELECT COUNT(*) AS presence
                                        FROM `prod__presence`
                                        WHERE `id` IN(
                                            SELECT MAX(`id`)
                                            FROM `prod__presence`
                                            WHERE `prod_line` LIKE '$prodline'
                                            GROUP BY `matricule`
                                        )
                                        AND `p_state` = 'in'
                                        AND `prod_line` LIKE '%$prodline%'
                                        AND `cur_date` >= DATE_SUB(CURRENT_DATE, INTERVAL 14 HOUR)
                                        AND `cur_time` >= DATE_SUB(CURRENT_TIME, INTERVAL 14 HOUR)";

                                    $rslt1 = $con->query($query1);
                                    while ($item = $rslt1->fetch_assoc()) {
                                        $tab[] = $item;
                                    };

                                    (int) $presence = (int) $tab[0]['presence'];

                                    if ($presence!=0){
                                    echo ($presence);} else {
                                        echo (0);
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="container">
            <p class="m-0 text-center text-indigo">Copyright &copy; Advantry X 2023</p>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
