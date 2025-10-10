<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

// ดึงข้อมูลสินค้าหน้าร้านจาก tb_products โดยตรง
$sql = "
    SELECT 
        p.product_id,
        p.product_name,
        p.product_pic,
        p.category_id,
        p.cost_price,
        p.sell_price,
        p.stock_qty
    FROM tb_products p
    WHERE p.is_active = 'Available'
    ORDER BY p.product_id ASC
";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
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
                <h2 class="fw-bold text-dark"><i class="fa-solid fa-shop">&nbsp;&nbsp;</i>สินค้าหน้าร้าน</h2>
                <hr class="w-25 border-3 border-primary">
            </center>

            <?php if ($total == 0): ?>
                <center>
                    <h3 class="text-danger mt-5"><b>ไม่พบข้อมูลสินค้าหน้าร้าน</b></h3>
                </center>
            <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-primary fw-bold mb-0">
                        ข้อมูลสินค้าหน้าร้านทั้งหมด <span class="text-dark">(<?=$total?> รายการ)</span>
                    </h4>
                </div>

                <div class="table-responsive shadow-sm rounded-3">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="text-center">
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>หมวดหมู่</th>
                                <th>จำนวนหน้าร้าน</th>
                                <th>ราคาทุน</th>
                                <th>ราคาขาย</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <?php 
                                    $img_path = "/project_assignment/asset/img/product/";
                                    $img = $row['product_pic'] ? $img_path . $row['product_pic'] : "/project_assignment/asset/img/product/no.jpg";    
                                ?>
                                <tr class="text-center">
                                    <td class="fw-bold"><?= $row['product_id'] ?></td>
                                    <td>
                                        <img src="<?= $img ?>" width="70" height="70" style="object-fit: cover; border-radius: 8px;"><br>
                                        <span class="fw-semibold text-dark"><?= $row['product_name'] ?></span>
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
                                    <td class="fw-bold text-primary"><?= number_format($row['stock_qty']) ?> ชิ้น</td>
                                    <td class="fw-bold text-danger"><?= number_format($row['cost_price'], 2) ?> ฿</td>
                                    <td class="fw-bold text-success"><?= number_format($row['sell_price'], 2) ?> ฿</td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
