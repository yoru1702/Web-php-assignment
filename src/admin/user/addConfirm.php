<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }
    $p = $_POST;
    $sql = "INSERT INTO tb_users VALUES (NULL,'$p[name_user]','$p[sname_user]','$p[tel]','$p[username]','$p[password]','$p[role_id]')";
    $res = mysqli_query($conn, $sql);

    $msg = $res ? "เพิ่มข้อมูลสำเร็จ" : "เพิ่มข้อมูลไม่สำเร็จ";
    $color = $res ? "green" : "red";
    echo "<center><font color='$color'><h2><b>$msg</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=user.php'>";
?>