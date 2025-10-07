<?php
    session_start();
    include '../../../include/config.inc.php';

    $p = $_POST;
    $sql = "INSERT INTO tb_users VALUES (NULL,'$p[name_user]','$p[sname_user]','$p[tel]','$p[username]','$p[password]','$p[role_id]')";
    $res = mysqli_query($conn, $sql);

    $msg = $res ? "เพิ่มข้อมูลสำเร็จ" : "เพิ่มข้อมูลไม่สำเร็จ";
    $color = $res ? "green" : "red";
    echo "<center><font color='$color'><h2><b>$msg</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=user.php'>";
?>