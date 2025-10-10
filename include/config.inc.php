<?php
    $serv = "localhost";
    $user = "root";
    $pass = "";
    $data = "assignment";
    $conn = mysqli_connect($serv, $user, $pass, $data);
    if (!$conn) {
        die("Error Connect! " . mysqli_connect_error());
    }


    //  แก้จุดพิมพ์ผิดจาก mysqli_set_ฟharset เป็น mysqli_set_charset
    mysqli_set_charset($conn, "utf8");

    //  ตั้ง timezone และปิด error warning
    date_default_timezone_set("Asia/Bangkok");
    // error_reporting(0);
    error_reporting(~E_NOTICE);
?>