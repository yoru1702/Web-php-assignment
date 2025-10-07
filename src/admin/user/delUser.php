<?php
    session_start();

    include '../../../include/config.inc.php';

    $product_id=$_REQUEST["product_id"];
    $product_pic=$_REQUEST["product_pic"];

    $sql="delete from tb_products where product_id='$product_id'";
    $result=mysqli_query($conn,$sql);
    unlink("product/$product_pic");
    
    if($result){
        echo "<center><font color='green'><h2><b>ลบข้อมูลสำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=product.php'>";
    }else{
        echo "<center><font color='red'><h2><b>ลบข้อมูลไม่สำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=product.php'>";
    }
?>