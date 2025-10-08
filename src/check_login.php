<?php
session_start();

include "../include/config.inc.php";

$user = $_REQUEST["user"] ?? "";
$pass = $_REQUEST["pass"] ?? "";

// ตรวจสอบค่าว่าง
if ($user == "" || $pass == "") {
    echo "<center><font color='red'><h2><b>กรุณากรอกชื่อผู้ใช้และรหัสผ่าน</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    exit();
}   

$stmt = $conn->prepare("SELECT * FROM tb_users WHERE username=? AND password=?");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();
// $result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num > 0) {
    $read = mysqli_fetch_assoc($result);

    $user_id    = $read["user_id"];
    $name_user  = $read["name_user"];
    $sname_user = $read["sname_user"];
    $tel        = $read["tel"];
    $role_id    = $read["role_id"];

    // set session
    // $_SESSION["valid_admin"] = ($role_id == 1) ? $user_id : null;
    $_SESSION["valid_admin"] = $role_id;
    $_SESSION["user_id"]     = $user_id;
    $_SESSION["name_user"]   = $name_user;
    $_SESSION["sname_user"]  = $sname_user;
    $_SESSION["role_id"]     = $role_id;
    $_SESSION["tel"]         = $tel;

    echo "<center><font color='green'><h2><b>เข้าสู่ระบบสำเร็จ</b></h2></font></center>";
    // if ($role_id == 1) {
        echo "<meta http-equiv='refresh' content='1;url=../src/admin/index.php'>";
    // } else {
    //     echo "<meta http-equiv='refresh' content='1;url=../src/staff/index.php'>";
    // }
} else {
    echo "<center><font color='red'><h2><b>เข้าสู่ระบบไม่สำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
}
?>