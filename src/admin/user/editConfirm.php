<?php
    session_start();
    include "../../../include/config.inc.php";

    // รับค่าจากฟอร์ม
    $product_id = $_POST["product_id"];
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $cost_price = $_POST["cost_price"];
    $sell_price = $_POST["sell_price"];
    $product_num = $_POST["product_num"];
    $category = $_POST["category"];
    $del = $_POST["del"];             // ติ๊กเพื่อลบรูป
    $product_pic = $_POST["product_pic"];     // รูปเก่า
    $pic_new = $_FILES["pic_new"]["tmp_name"];
    $pic_new_name = $_FILES["pic_new"]["name"];

    // ✅ อัปเดตข้อมูลพื้นฐาน
    $sql1 = "UPDATE tb_products SET 
                product_name='$product_name',
                cost_price='$cost_price',
                sell_price='$sell_price',
                product_num='$product_num',
                category_id='$category'
            WHERE product_id='$product_id'";
    $result1 = mysqli_query($conn, $sql1);

    // ถ้าติ๊ก "ลบรูป"
    if ($del == 1) {
        $sql2 = "UPDATE tb_products SET product_pic='' WHERE product_id='$product_id'";
        mysqli_query($conn, $sql2);

        if ($product_pic && file_exists("product/$product_pic")) {
            unlink("product/$product_pic");
        }
    }

    // ถ้ามีการอัปโหลดรูปใหม่
    if ($pic_new != "") {
        $type = strtolower($pic_new_name);
        $ext = strrchr($type, ".");
        if ($ext == ".jpg" or $ext == ".png" or $ext == ".gif" or $ext == ".jpeg") {
            $filename = "p" . $product_id . $ext;
            copy($pic_new, "product/$filename");

            $sql3 = "UPDATE tb_products SET product_pic='$filename' WHERE product_id='$product_id'";
            mysqli_query($conn, $sql3);

            // ลบรูปเก่าออก
            if ($product_pic && file_exists("product/$product_pic")) {
                unlink("product/$product_pic");
            }
        } else {
            echo "<center><font color='red'><h2><b>นามสกุลไฟล์ไม่ถูกต้อง (.jpg, .png, .gif เท่านั้น)</b></h2></font></center>";
            echo "<meta http-equiv='refresh' content='1;url=product.php'>";
            exit();
        }
    }

    // ✅ แสดงผลลัพธ์
    if ($result1) {
        echo "<center><font color='green'><h2><b>แก้ไขข้อมูลสำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=product.php'>";
    } else {
        echo "<center><font color='red'><h2><b>แก้ไขข้อมูลไม่สำเร็จ</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='1;url=product.php'>";
    }
?>