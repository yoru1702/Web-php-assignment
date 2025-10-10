<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

    if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }

    $p = $_POST;
    $product_id = $p['product_id'];

    $sql = "SELECT * FROM tb_products WHERE product_id='$product_id'";
    $read = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>
<form action="editConfirm.php" enctype="multipart/form-data" method="POST" onsubmit="return check()">
    <div class="modal-content" style="border-radius:30px">
        <div class="modal-header" style="border-radius: 29px 29px 0 0;">
            <h2><b><center>แก้ไขข้อมูลสินค้า</center></b></h2>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4 py-1">
                    <label>ชื่อสินค้า :</label>
                    <input type="text" class="form-control" name="product_name" value="<?= $read['product_name'] ?>" required>
                </div>
                <div class="col-sm-4 py-1">
                    <label>ราคาต้นทุน :</label>
                    <input type="text" class="form-control" name="cost_price" value="<?= $read['cost_price'] ?>" required>
                </div>
                <div class="col-sm-4 py-1">
                    <label>ราคาขาย :</label>
                    <input type="text" class="form-control" name="sell_price" value="<?= $read['sell_price'] ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 py-1">
                    <label>จำนวนสินค้า :</label>
                    <input type="text" class="form-control" name="product_num" value="<?= $read['product_num'] ?>" required>
                </div>
                <div class="col-sm-6 py-1">
                    <label>หมวดหมู่สินค้า :</label>
                    <select name="category" class="form-select" required>
                        <option value="">---หมวดหมู่สินค้า---</option>
                        <?php
                        $categories = [1=>"เครื่องดื่ม",2=>"อาหารแห้ง",3=>"ขนม",4=>"ของใช้ส่วนตัว",5=>"ผลิตภัณฑ์ทำความสะอาด",6=>"เครื่องเขียน"];
                        foreach($categories as $id=>$name){
                            $sel = ($read['category_id']==$id) ? "selected" : "";
                            echo "<option value='$id' $sel>$name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 py-1">
                    <label>สถานะสินค้า :</label>
                    <select name="is_active" class="form-select" required>
                        <option value="Available" <?= ($read['is_active']=='Available')?'selected':''; ?>>พร้อมขาย</option>
                        <option value="Not Available" <?= ($read['is_active']=='Not Available')?'selected':''; ?>>ไม่พร้อมขาย</option>
                    </select>
                </div>
                <div class="col-sm-6 py-1">
                    <label>รูปสินค้า :</label><br>
                    <?php if($read['product_pic']): ?>
                        <center>
                            <input type="checkbox" name="del" value="1"> ลบ
                            <br><img src="product/<?= $read['product_pic'] ?>" class="rounded-pill" width="200">
                        </center>
                    <?php else: ?>
                        <input type="file" class="form-control" name="pic_new" accept=".jpg,.png,.gif">
                        <small class="text-danger">[เฉพาะไฟล์ .jpg .png และ .gif]</small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 py-1">
                    <label>หมายเหตุ (ไม่บังคับ) :</label>
                    <textarea name="note" id="note" class="form-control" rows="5" placeholder="เช่น แก้ไขราคาต้นทุนสินค้าเนื่องจาก 10 บาท เป็น 16 บาท"></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer bg-1 text-center">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" name="product_pic" value="<?= $read['product_pic'] ?>">
            <button class="btn btn-lg btn-warning" type="submit" style="border-radius:30px">แก้ไข</button>
            <button class="btn btn-lg btn-danger" type="reset" style="border-radius:30px">ยกเลิก</button>
        </div>
    </div>
</form>
