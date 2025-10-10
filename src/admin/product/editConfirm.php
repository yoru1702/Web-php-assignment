<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

if($_SESSION["valid_admin"]==""){
    echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
    exit();
}

// รับค่าจากฟอร์ม
$product_id   = $_POST["product_id"];
$product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
$cost_price   = $_POST["cost_price"];
$sell_price   = $_POST["sell_price"];
$product_num  = $_POST["product_num"];
$category     = $_POST["category"];
$is_active    = $_POST["is_active"]; // ✅ รับค่าจาก dropdown สถานะสินค้า

$del          = isset($_POST["del"]) ? $_POST["del"] : 0; // ✅ ป้องกัน notice
$product_pic  = $_POST["product_pic"];
$pic_new      = $_FILES["pic_new"]["tmp_name"];
$pic_new_name = $_FILES["pic_new"]["name"];

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/project_assignment/asset/img/product/";

// อัปเดตข้อมูล
$sql1 = "UPDATE tb_products SET 
            product_name='$product_name',
            cost_price='$cost_price',
            sell_price='$sell_price',
            product_num='$product_num',
            category_id='$category',
            is_active='$is_active'
        WHERE product_id='$product_id'";
$result1 = mysqli_query($conn, $sql1);

// ถ้าลบรูป
if ($del == 1) {
    $sql2 = "UPDATE tb_products SET product_pic='' WHERE product_id='$product_id'";
    mysqli_query($conn, $sql2);

    $old_path = $upload_dir . $product_pic;
    if ($product_pic && file_exists($old_path)) {
        unlink($old_path);
    }
    $product_pic = "";
}

// ถ้ามีอัปโหลดรูปใหม่
if (!empty($pic_new)) {
    $type = strtolower($pic_new_name);
    $ext = strrchr($type, ".");
    if (in_array($ext, [".jpg", ".jpeg", ".png", ".gif"])) {

        // ตั้งชื่อไฟล์ใหม่
        $filename = "p" . $product_id . $ext;
        $target_path = $upload_dir . $filename;

        // ลบรูปเก่าถ้ามี
        $old_path = $upload_dir . $product_pic;
        if ($product_pic && file_exists($old_path)) {
            unlink($old_path);
        }

        // คัดลอกรูปใหม่
        if (copy($pic_new, $target_path)) {
            $sql3 = "UPDATE tb_products SET product_pic='$filename' WHERE product_id='$product_id'";
            mysqli_query($conn, $sql3);
        } else {
            echo "<center><font color='red'><h2><b>อัปโหลดรูปไม่สำเร็จ</b></h2></font></center>";
            echo "<meta http-equiv='refresh' content='2;url=product.php'>";
            exit();
        }
    } else {
        echo "<center><font color='red'><h2><b>นามสกุลไฟล์ไม่ถูกต้อง (.jpg, .png, .gif เท่านั้น)</b></h2></font></center>";
        echo "<meta http-equiv='refresh' content='2;url=product.php'>";
        exit();
    }
}

// แสดงผลลัพธ์
if ($result1) {
    echo "<center><font color='green'><h2><b>✅ แก้ไขข้อมูลสำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=product.php'>";
} else {
    echo "<center><font color='red'><h2><b>❌ แก้ไขข้อมูลไม่สำเร็จ</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=product.php'>";
}
?>
