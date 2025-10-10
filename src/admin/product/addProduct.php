<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }
?>
<form action="addConfirm.php" enctype="multipart/form-data" onsubmit="return check()" method="post">
    <div class="modal-content" style="border-radius:30px">
        <div class="modal-header" style="background: linear-gradient(90deg,#108baa,#07c274);color: #fff;border-radius: 29px 29px 0 0;">
            <h2 class="modal-title"><b>เพิ่มสินค้า</b></h2>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-sm-4">
                    <label class="form-label">ชื่อสินค้า :</label>
                    <input type="text" class="form-control" name="product_name" id="product_name"
                        placeholder="กรอกชื่อสินค้า" required>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">ราคาต้นทุน :</label>
                    <input type="number" step="0.01" class="form-control" name="cost_price" id="cost_price"
                        placeholder="ระบุราคาต้นทุน" required>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">ราคาขาย :</label>
                    <input type="number" step="0.01" class="form-control" name="sell_price" id="sell_price"
                        placeholder="ระบุราคาขาย" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">จำนวนสินค้า :</label>
                    <input type="number" class="form-control" name="product_num" id="product_num"
                        placeholder="จำนวนสินค้า" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">หมวดหมู่สินค้า :</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="">--- เลือกหมวดหมู่ ---</option>
                        <option value="1">เครื่องดื่ม</option>
                        <option value="2">อาหารแห้ง</option>
                        <option value="3">ขนม</option>
                        <option value="4">ของใช้ส่วนตัว</option>
                        <option value="5">ผลิตภัณฑ์ทำความสะอาด</option>
                        <option value="6">เครื่องเขียน</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">รูปสินค้า :</label>
                    <input type="file" class="form-control" name="product_pic" id="product_pic"
                        accept=".jpg,.jpeg,.png,.gif">
                    <small class="text-danger">[เฉพาะไฟล์ .jpg, .png, .gif เท่านั้น]</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 py-1">
                    <label>หมายเหตุ (ไม่บังคับ) :</label>
                    <textarea name="note" id="note" class="form-control" rows="5" placeholder="เช่น เพิ่มสินค้าเนื่องจากล็อตใหม่"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-lg btn-success" type="submit" style="border-radius:30px">เพิ่มข้อมูล</button>
            <button class="btn btn-lg btn-danger" type="reset" style="border-radius:30px">ยกเลิก</button>
        </div>
    </div>
</form>