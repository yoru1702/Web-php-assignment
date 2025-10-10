<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

// ดึงข้อมูลสินค้าที่ถูกเบิกออกจากคลัง (รวมจำนวนทั้งหมด)
$sql = "
    SELECT 
        p.product_id,
        p.product_name,
        p.product_pic,
        p.category_id,
        p.cost_price,
        p.sell_price,
        IFNULL(SUM(m.stock_qty), 0) AS total_qty_out
    FROM tb_products p
    LEFT JOIN tb_stock_movement m 
        ON p.product_id = m.product_id 
        AND m.movement_type = 'เบิกสินค้า'
    WHERE p.is_active = 'Available'
    GROUP BY 
        p.product_id, 
        p.product_name, 
        p.product_pic, 
        p.category_id, 
        p.cost_price, 
        p.sell_price
    ORDER BY p.product_id ASC
";

$Data = mysqli_query($conn, $sql);
$Num = mysqli_num_rows($Data);
?>

<div class="row">
    <!-- Sidebar -->
    <div class="col-lg-2 col-sm-3 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-lg-10 col-sm-9 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php'; ?>
        <br><br><br><br><br>

        <div class="container my-4">
            <center>
                <h2 class="fw-bold text-dark">สินค้าหน้าร้าน</h2>
                <hr class="w-25 border-3 border-primary">
            </center>

            <?php if ($Num == 0): ?>
                <center>
                    <h3 class="text-danger mt-5"><b>ไม่พบข้อมูลการเบิกสินค้า</b></h3>
                </center>
            <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-primary fw-bold mb-0">
                        ข้อมูลสินค้าหน้าร้านทั้งหมด <span class="text-dark">(<?=$Num?> รายการ)</span>
                    </h4>
                </div>
                <div class="table-responsive shadow-sm rounded-3">
                    <table class="table table-hover table-striped align-middle">
                            <tr>
                                <th scope="col">รหัสสินค้า</th>
                                <th scope="col">ชื่อสินค้า</th>
                                <th scope="col">หมวดหมู่</th>
                                <th scope="col">จำนวนหน้าร้าน</th>
                                <th scope="col">ราคาทุน</th>
                                <th scope="col">ราคาขาย</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($Data)): ?>
                                <?php 
                                    $img_path = "/project_assignment/asset/img/product/";
                                    $img = $row['product_pic'] ? $img_path . $row['product_pic'] : "/project_assignment/asset/img/product/no.jpg";    
                                ?>
                                <tr class="text-center">
                                    <td class="fw-bold"><?=$row['product_id']?></td>
                                    <td>
                                        <img src="<?= $img ?>" width="70" height="70" style="object-fit: cover; border-radius: 8px;"><br>
                                        <span class="fw-semibold text-dark"><?=$row['product_name']?></span>
                                    </td>
                                    <td>
                                        <?= [
                                            "1" => "เครื่องดื่ม",
                                            "2" => "อาหารแห้ง",
                                            "3" => "ขนม",
                                            "4" => "ของใช้ส่วนตัว",
                                            "5" => "ผลิตภัณฑ์ทำความสะอาด",
                                            "6" => "เครื่องเขียน"
                                        ][$row['category_id']] ?? "-" ?>
                                    </td>
                                    <td class="fw-bold text-primary">
                                        <?= number_format($row['total_qty_out'] ?? 0) ?> ชิ้น
                                    </td>
                                    <td class="fw-bold text-danger">
                                        <?= number_format($row['cost_price'], 2) ?> ฿
                                    </td>
                                    <td class="fw-bold text-success">
                                        <?= number_format($row['sell_price'], 2) ?> ฿
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
