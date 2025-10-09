<?php
    session_start();
    
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';

    $type=$_POST["type"];
    if ($type == "") {
        $sql = "SELECT * FROM tb_products WHERE is_active='Available' ORDER BY product_id ASC";
    } else {
        $sql = "SELECT * FROM tb_products WHERE category_id='$type' AND is_active='Available' ORDER BY product_id ASC";
    }

    $Data = mysqli_query($conn, $sql);
    $Num = mysqli_num_rows($Data);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php'; ?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php';?><br><br><br><br><br>
        <div class="container"><br>
            <center><h2><b>Stock สินค้า</b></h2></center><br>
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <form action="stock.php" method="post">
                        <div class="input-group">
                            <select name="type" id="type" class="form-select" required>
                                <option value="">---หมวดหมู่สินค้า---</option>
                                <option value="1">เครื่องดื่ม</option>
                                <option value="2">อาหารแห้ง</option>
                                <option value="3">ขนม</option>
                                <option value="4">ของใช้ส่วนตัว</option>
                                <option value="5">ผลิตภัณฑ์ทำความสะอาด</option>
                                <option value="6">เครื่องเขียน</option>
                            </select>
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </form><br>
                </div>
                <div class="col-lg-4 col-sm-4">
                </div>
                <div class="col-lg-4 col-sm-4">
                </div>
            </div><hr>
            <?php if($Num==0): ?>
                <center><h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2></center><br>
            <?php else: ?>
                <center><h2 class="text-primary"><b>ข้อมูล <?=$Num?> รายการ</b></h2></center><br>
            <table class="table table-hover table-striped mt-3">
                    <tr align="center">
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>หมวดหมู่</th>
                        <th>จำนวน</th>
                        <th>ราคาทุน</th>
                        <th>ราคาขาย</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($Data)): ?>
                    <tr align="center">
                        <td><?=$row['product_id']?></td>
                        <td>
                            <img src="product/<?=$row['product_pic']?>" class="rounded-pill" width="100"><br>
                            <?=$row['product_name']?>
                        </td>
                        <td>
                            <?=["1"=>"เครื่องดื่ม","2"=>"อาหารแห้ง","3"=>"ขนม","4"=>"ของใช้ส่วนตัว","5"=>"ผลิตภัณฑ์ทำความสะอาด","6"=>"เครื่องเขียน"][$row['category_id']] ?? "-"?>
                        </td>
                        <td><?=$row['product_num']?></td>
                        <td class="text-danger fw-bold"><?=number_format($row['cost_price'],2)?> ฿</td>
                        <td class="text-success fw-bold"><?=number_format($row['sell_price'],2)?> ฿</td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php
                endif;
            ?>
        </div>
    </div>
</div>