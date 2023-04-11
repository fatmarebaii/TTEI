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
    </head>
    <body>
        <?php require_once './config.php'; ?>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-indigo">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="http://advantryx.com/"> <img src="img/logo.png" alt="Logo" style="width:40mm;height:15mm"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></button>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="prodline"> Prod-Line: <?php if (isset($_GET["prod_line"])) {
                        $prodline=$_GET["prod_line"];
                        echo ($prodline);}?> </h4></div>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="date"> DATE: <?php echo date('d/m/Y');?> </h4></div>
                <div class="collapse navbar-collapse"><h4 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo" id="time"> HEURE: <?php echo (date('H:i:s'));?> </h4></div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <h1 class="navbar-nav ms-auto mb-2 mb-lg-0 text-indigo"> TTEI </h1>
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
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/eng.svg" alt="icone"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Engaged Quantity</h2>
                                <div id="qteEng" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                $sql="SELECT * FROM `prod__product`";
                                $rslt=$con->query($sql);

                                $product=[];

                                $EQ=0;
                                while ($item = $rslt->fetch_assoc())
                                {
                                    $product[] = $item;
                                }

                                for($i=0; $i<count($product); $i++){
                                    $EQ += $product[$i]['pack_quantity'];
                                }
                                echo ($EQ);
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/prog.svg" alt="icone"></div>
                                <h2 class="fs-4 fw-bold text-indigo">In Progress Quantity</h2>
                                <div id="qteProg" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                echo ($EQ);?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/out.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Fabricated Quantity</h2>
                                <div id="qteFab" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/settings.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Productivity</h2>
                                <div id="prod" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/activity.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Parts-Per-Million</h2>
                                <div id="ppm" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
                                ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4 mb-4">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient rounded-3 mb-4 mt-n4"><img src="./img/clock.svg" alt="icon"></div>
                                <h2 class="fs-4 fw-bold text-indigo">Non-Productive Time</h2>
                                <div id="npt" class="h2 mb-2 font-weight-bold text--bs-gray-900"> <?php
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
