<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

// ตรวจสอบว่ามีสินค้าเลือกมาหรือไม่
if (empty($_POST['selected'])) {
    echo "<script>alert('กรุณาเลือกสินค้าก่อนทำรายการขาย');history.back();</script>";
    exit;
}

// ตั้งค่าเริ่มต้น
date_default_timezone_set("Asia/Bangkok");
$sale_no = time(); // ใช้ timestamp เป็นเลขที่ขาย (ไม่ซ้ำ)
$sale_datetime = date("Y-m-d H:i:s");
$user_id = $_SESSION['user_id'] ?? null; // ถ้า login แล้วจะมี user_id
$vatRate = 7;

// ตัวแปรรวม
$subtotal = 0;
$tax = 0;
$total = 0;

// เริ่มการขาย (รวมยอดขายก่อนบันทึก)
foreach ($_POST['selected'] as $product_id) {
    $qty = intval($_POST['qty'][$product_id]);
    $price = floatval($_POST['price'][$product_id]);

    if ($qty <= 0) continue; // ข้ามถ้าไม่ได้กรอกจำนวน

    $line_total = $qty * $price;
    $subtotal += $line_total;
}

// คำนวณภาษี
$tax = $subtotal * $vatRate / 100;
$total = $subtotal + $tax;

// 🔹 บันทึกข้อมูลลง tb_sales
$sqlSale = "
    INSERT INTO tb_sales (sale_no, sale_datetime, subtotal, tax, total, user_id)
    VALUES ('$sale_no', '$sale_datetime', '$subtotal', '$tax', '$total', " . ($user_id ? "'$user_id'" : "NULL") . ")
";
if (!mysqli_query($conn, $sqlSale)) {
    die("Error saving sale: " . mysqli_error($conn));
}

// ดึง sale_id ที่เพิ่งสร้าง
$sale_id = mysqli_insert_id($conn);

// 🔹 บันทึกรายการสินค้าที่ย่อย tb_salestime และลด stock
foreach ($_POST['selected'] as $product_id) {
    $qty = intval($_POST['qty'][$product_id]);
    $price = floatval($_POST['price'][$product_id]);
    if ($qty <= 0) continue;

    $line_total = $qty * $price;

    // เพิ่มข้อมูลลง tb_salestime
    $sqlItem = "
        INSERT INTO tb_salestime (sale_id, product_id, qty, unit_price, line_total)
        VALUES ('$sale_id', '$product_id', '$qty', '$price', '$line_total')
    ";
    mysqli_query($conn, $sqlItem);

    // ตรวจสอบและลดจำนวนสินค้าในหน้าร้าน
    $sqlCheckStock = "SELECT stock_qty FROM tb_products WHERE product_id = '$product_id'";
    $resStock = mysqli_query($conn, $sqlCheckStock);
    $rowStock = mysqli_fetch_assoc($resStock);
    $currentStock = (int)$rowStock['stock_qty'];

    if ($currentStock < $qty) {
        echo "<script>alert('❌ สินค้า ID $product_id มีไม่พอในสต็อก (เหลือ $currentStock ชิ้น)');history.back();</script>";
        exit;
    }

    // ลดจำนวนหน้าร้าน
    $newStock = $currentStock - $qty;
    $sqlUpdateStock = "UPDATE tb_products SET stock_qty = '$newStock' WHERE product_id = '$product_id'";
    mysqli_query($conn, $sqlUpdateStock);

    // ถ้าขายเกิน stock
    if (mysqli_affected_rows($conn) == 0) {
        echo "<script>alert('ขายสินค้าเกินจำนวนคงเหลือของสินค้า ID $product_id');history.back();</script>";
        exit;
    }
}

// 🔹 แสดงผลหลังขายเสร็จ
echo "<script>
    alert('บันทึกการขายเรียบร้อยแล้ว\\nยอดรวมสุทธิ: " . number_format($total, 2) . " บาท');
    window.location.href = '/project_assignment/src/admin/saleManage.php';
</script>";
exit;
?>
