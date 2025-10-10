<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    if($_SESSION["valid_admin"]==""){
            echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
            exit();
        }

    $user_id=$_REQUEST["user_id"];

    $sql="delete from tb_users where user_id='$user_id'";
    $result=mysqli_query($conn,$sql);
    
    if($result){
        echo "<center><font color='green'><h2><b>✅ ลบข้อมูลสำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=user.php'>";
    }else{
        echo "<center><font color='red'><h2><b>❌ ลบข้อมูลไม่สำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=user.php'>";
    }
?>