<?php
session_start();
include '../../../include/config.inc.php';
include '../../../include/function.php';

$type = $_POST["type"];
if ($type == "") {
    $Data = getProduct($conn);
} else {
    $sql = "SELECT * FROM tb_products WHERE category_id='$type' ORDER BY product_id ASC";
    $Data = mysqli_query($conn, $sql);
}
$Num = mysqli_num_rows($Data);
?>
<link rel="stylesheet" href="../../../asset/css/bootstrap.min.css">
<link rel="stylesheet" href="../../asset/css/style.css">
<script src="../../../asset/js/bootstrap.bundle.min.js"></script>
<script src="../../../asset/js/jquery-3.7.1.min.js"></script>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "../navbar.php"; ?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <div class="container"><br>
            <center><h2><b>รายงานสินค้าคงคลัง</b></h2></center><br>
            <a class="btn btn-primary" href="report_product2.php" target="_blank">พิมพ์รายงาน</a><br><hr><br>
        </div>

        <?php if ($Num == 0): ?>
            <center><h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2></center>
        <?php else: ?>
            <center><h2 class="text-primary"><b>ข้อมูล <?=$Num?> รายการ</b></h2></center>
            <table class="table table-hover table-striped mt-3">
                <tr align="center">
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>จำนวน</th>
                    <th>ราคาทุน</th>
                    <th>ราคาขาย</th>
                    <th>กำไรต่อหน่วย</th>
                    <th>กำไรรวม</th>
                </tr>
                <?php 
                // ตัวแปรเก็บยอดรวม
                $sum_num = 0;
                $sum_cost = 0;
                $sum_sell = 0;
                $sum_profit = 0;

                while ($row = mysqli_fetch_assoc($Data)):
                    $profit_unit = $row['sell_price'] - $row['cost_price']; // กำไรต่อชิ้น
                    $profit_total = $profit_unit * $row['product_num']; // กำไรรวมของสินค้านั้น

                    $sum_num += $row['product_num'];
                    $sum_cost += $row['cost_price'] * $row['product_num'];
                    $sum_sell += $row['sell_price'] * $row['product_num'];
                    $sum_profit += $profit_total;
                ?>
                <tr align="center">
                    <td><?=$row['product_id']?></td>
                    <td>
                        <?php if(!empty($row['product_pic'])): ?>
                            <img src="product/<?=$row['product_pic']?>" class="rounded-pill mb-2" width="80"><br>
                        <?php endif; ?>
                        <?=$row['product_name']?>
                    </td>
                    <td>
                        <?=["1"=>"เครื่องดื่ม","2"=>"อาหารแห้ง","3"=>"ขนม","4"=>"ของใช้ส่วนตัว","5"=>"ผลิตภัณฑ์ทำความสะอาด","6"=>"เครื่องเขียน"][$row['category_id']] ?? "-"?>
                    </td>
                    <td><?=$row['product_num']?></td>
                    <td class="text-danger"><?=number_format($row['cost_price'],2)?> ฿</td>
                    <td class="text-success fw-bold"><?=number_format($row['sell_price'],2)?> ฿</td>
                    <td class="text-primary fw-bold"><?=number_format($profit_unit,2)?> ฿</td>
                    <td class="text-success fw-bold"><?=number_format($profit_total,2)?> ฿</td>
                </tr>
                <?php endwhile; ?>
                <!-- ผลรวม -->
                <tr align="center"class="fw-bold">
                    <td colspan="3"><h4>ยอดรวมทั้งหมด</h4></td>
                    <td class=""><?=number_format($sum_num)?></td>
                    <td class="text-danger"><?=number_format($sum_cost,2)?> ฿</td>
                    <td class="text-success"><?=number_format($sum_sell,2)?> ฿</td>
                    <td>-</td>
                    <td class="text-primary"><?=number_format($sum_profit,2)?> ฿</td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</div>
