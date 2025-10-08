<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

    if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=login.php'>";
        exit();
    }
    unset($_SESSION["valid_admin"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["name_user"]);
    unset($_SESSION["sname_user"]);
    unset($_SESSION["role_id"]);
    unset($_SESSION["tel"]);
    echo "<center><font color='red'><h2><b>ออกจากระบบสำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='3;url=login.php'>";
?>