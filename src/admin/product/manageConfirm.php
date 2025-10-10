<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

// ✅ ตรวจว่ามีข้อมูลจากฟอร์มหรือไม่
if (!isset($_POST['product']) || !isset($_POST['num'])) {
    echo "<center><font color='red'><h2><b>ไม่มีข้อมูลสินค้า</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=manageSales.php'>";
    exit;
}

$product_id = (int)$_POST['product'];
$qty        = (int)$_POST['num'];
$user_id    = $_SESSION['user_id'] ?? 1; 
$date       = date("Y-m-d H:i:s");

// ✅ ดึงข้อมูลสินค้า
$sql = "SELECT product_num, stock_qty, product_name FROM tb_products WHERE product_id = $product_id";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    echo "<center><font color='red'><h2><b>ไม่พบสินค้านี้ในคลัง</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=manageSales.php'>";
    exit;
}

$current_stock = (int)$row['product_num'];  // สินค้าในคลัง
$current_shop  = (int)$row['stock_qty'];    // สินค้าหน้าร้าน (ใหม่)
$product_name  = $row['product_name'];

// ✅ ตรวจสอบว่าสินค้าพอไหม
if ($qty > $current_stock) {
    echo "<center><font color='red'><h2><b>จำนวนสินค้าที่ต้องการเบิกเกินกว่าที่มีในคลัง!</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='2;url=manageSales.php'>";
    exit;
}

// หักจำนวนออกจากคลัง และเพิ่มเข้าหน้าร้าน
$new_stock = $current_stock - $qty;
$new_shop  = $current_shop + $qty;

$update_sql = "
    UPDATE tb_products 
    SET 
        product_num = $new_stock,
        stock_qty = $new_shop
    WHERE product_id = $product_id
";

if (!mysqli_query($conn, $update_sql)) {
    die('อัปเดตจำนวนสินค้าไม่สำเร็จ: ' . mysqli_error($conn));
}

// บันทึกประวัติการเบิก
$note_text = "เบิกสินค้า $product_name จำนวน {$qty} ชิ้น จากคลังเข้าหน้าร้าน";
$log_sql = "
    INSERT INTO tb_stock_movement (product_id, movement_type, qty_signed, note, user_id, created_at, stock_qty)
    VALUES ($product_id, 'เบิกสินค้า', '-', '$note_text', $user_id, '$date', $qty)
";

if (!mysqli_query($conn, $log_sql)) {
    die('บันทึกประวัติการเบิกไม่สำเร็จ: ' . mysqli_error($conn));
}

//  แสดงข้อความสำเร็จ
echo "<center><font color='green'><h2><b>เบิกสินค้าเรียบร้อยแล้ว</b></h2></font></center>";
echo "<meta http-equiv='refresh' content='1;url=manageAll.php'>";
?>
