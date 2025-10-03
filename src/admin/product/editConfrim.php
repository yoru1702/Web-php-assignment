<?php
session_start();
include '../../../include/config.inc.php';
include '../../../include/function.php';

// รับค่าจากฟอร์ม
$p = $_POST;
$product_id   = $p['product_id'];
$product_name = mysqli_real_escape_string($conn, $p['product_name']);
$cost_price   = $p['cost_price'];
$sell_price   = $p['sell_price'];
$product_num  = $p['product_num'];
$category_id  = $p['category'];
$product_pic  = $p['product_pic']; // รูปเดิม

// โฟลเดอร์เก็บรูป
$upload_dir = "product/";
$new_pic = "";

// ✅ ถ้าติ๊ก "ลบรูป" → ลบไฟล์เก่า
if(isset($p['del']) && $p['del']=="1"){
    if($product_pic && file_exists($upload_dir.$product_pic)){
        unlink($upload_dir.$product_pic);
    }
    $new_pic = ""; // เคลียร์ค่าเป็นค่าว่าง
}
// ✅ ถ้ามีการอัปโหลดรูปใหม่
elseif(isset($_FILES['pic_new']) && $_FILES['pic_new']['name']!=""){
    $ext = strtolower(pathinfo($_FILES['pic_new']['name'], PATHINFO_EXTENSION));
    $allow = ['jpg','jpeg','png','gif'];

    if(in_array($ext, $allow)){
        $new_pic = "p".time().".".$ext;
        move_uploaded_file($_FILES['pic_new']['tmp_name'], $upload_dir.$new_pic);

        // ลบรูปเก่า
        if($product_pic && file_exists($upload_dir.$product_pic)){
            unlink($upload_dir.$product_pic);
        }
    }else{
        echo "<script>alert('ประเภทไฟล์ไม่ถูกต้อง!');history.back();</script>";
        exit;
    }
}else{
    $new_pic = $product_pic; // ถ้าไม่ลบ/ไม่อัปโหลด ใช้รูปเดิม
}

// ✅ อัปเดตข้อมูลลง DB
$sql = "UPDATE tb_products SET 
            product_name='$product_name',
            cost_price='$cost_price',
            sell_price='$sell_price',
            product_num='$product_num',
            category_id='$category_id',
            product_pic='$new_pic'
        WHERE product_id='$product_id'";

if(mysqli_query($conn, $sql)){
    echo "<script>alert('แก้ไขข้อมูลสำเร็จ!');window.location='product.php';</script>";
}else{
    echo "<script>alert('เกิดข้อผิดพลาด: ".mysqli_error($conn)."');history.back();</script>";
}
?>
