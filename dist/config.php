<?php
$con = mysqli_connect("localhost", "root", "", "ttei_db");
if ($con) {
    // echo "DB connected";
} else {
    echo "DB connection is failed";
    exit();
}
