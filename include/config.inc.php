<?php
<<<<<<< HEAD
=======
    // ini_set('session.cookie_path', '/');
>>>>>>> 17d20507b4be12d7d54d0153713e8dd5d5b01cb6
    $serv = "localhost";
    $user = "root";
    $pass = "";
    $data = "assignment";
    $conn = mysqli_connect($serv, $user, $pass, $data);
    if (!$conn) {
        die("Error Connect! " . mysqli_connect_error());
    }


    mysqli_set_charset($conn, "utf8");

    //  ตั้ง timezone และปิด error warning
    date_default_timezone_set("Asia/Bangkok");
    // error_reporting(0);
    error_reporting(~E_NOTICE);
?>