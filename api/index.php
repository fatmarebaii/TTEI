<?php require_once './config.php';
$date=date('d/m/Y');
$heure=date('H:i:s');
if (isset($_GET["prod_line"]) || isset ($_GET["prod"])) {
    $prodline=$_GET["prod_line"];
    $prod=$_GET["prod"];

    //determiner la QTE ENGAGEE
    $sql="SELECT * FROM `prod__product` WHERE `prod_line`='$prodline'";
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

    //determiner la QTE ENCOURS(= QTE DANS LA CHAINE- QTE FABRIQUEE)
    $sql1="SELECT * FROM `prod__control` WHERE `prod_line`='$prodline'";
    $rslt1=$con->query($sql1);

    $control=[];

    $Fab=0;
    $NOK=0;
    while ($item = $rslt1->fetch_assoc())
    {
        $control[] = $item;
    }

    for($i=0; $i<count($control); $i++){
        $Fab += $control[$i]['OK'] +$control[$i]['NOK'];
        $NOK +=$control[$i]['NOK'];
    }
    $ENCQ = $EQ-$Fab;

    echo json_encode([
        "DATE"=>$date,
        "HEURE"=> $heure,
        "PROD_LINE"=> $prodline,
        "QENGAGEE"=> $EQ,
        "QENCOURS"=> $ENCQ,
        "QFABRIQUEE"=> $Fab,
        "QTE DEFEC"=> $NOK,
        "Parts-Per-Million"=> round(($NOK/$Fab),3),
        "LA CHAINE QUI SERA AFFICHER ENSUITE"=> $prod,
    ]);
}
?>
