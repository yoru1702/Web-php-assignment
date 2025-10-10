<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }

// รับค่าจากฟอร์มแก่ไข
$user_id    = $_POST["user_id"];
$name_user  = mysqli_real_escape_string($conn, $_POST["name_user"]);
$sname_user = mysqli_real_escape_string($conn, $_POST["sname_user"]);
$username   = mysqli_real_escape_string($conn, $_POST["username"]);
$password   = mysqli_real_escape_string($conn, $_POST["password"]);
$tel        = mysqli_real_escape_string($conn, $_POST["tel"]);
$role_id    = $_POST["role_id"];

// อัปเดตข้อมูลในฐานข้อมูล
$sql = "UPDATE tb_users SET name_user='$name_user', sname_user='$sname_user', username='$username', password='$password', tel='$tel', role_id='$role_id'
        WHERE user_id='$user_id'";

$result = mysqli_query($conn, $sql);

//  แสดงข้อความ
if ($result) {
    echo "<center><font color='green'><h2><b>✅ แก้ไขข้อมูลพนักงานสำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=user.php'>";
} else {
    echo "<center><font color='red'><h2><b>❌ แก้ไขข้อมูลพนักงานไม่สำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=user.php'>";
}
?>
