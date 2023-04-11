<?php
//$con = mysqli_connect("127.0.0.1", "admin", "DigiTex@2022", "ttei_db");
$con = mysqli_connect("localhost", "root", "", "ttei_db");
if ($con) {
    // echo "DB connected";
} else {
    echo "DB connection is failed";
    exit();
}
