<?php
    session_start();
    include '../../../include/config.inc.php';
?>
<form action="addConfirm.php" enctype="multipart/form-data" onsubmit="return check()" method="post"></form>
    <div class="modal-header">
        <h5 class="modal-title"><b>เพิ่มสินค้า</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="row g-3">
            <div class="col-sm-4">
                <label class="form-label">ชื่อสินค้า :</label>
                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="กรอกชื่อสินค้า" required>
            </div>
            <div class="col-sm-4">
                <label class="form-label">ราคาต้นทุน :</label>
                <input type="number" step="0.01" class="form-control" name="cost_price" id="cost_price" placeholder="ระบุราคาต้นทุน" required>
            </div>
            <div class="col-sm-4">
                <label class="form-label">ราคาขาย :</label>
                <input type="number" step="0.01" class="form-control" name="sell_price" id="sell_price" placeholder="ระบุราคาขาย" required>
            </div>
            <div class="col-sm-6">
                <label class="form-label">จำนวนสินค้า :</label>
                <input type="number" class="form-control" name="product_num" id="product_num" placeholder="จำนวนสินค้า" required>
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
                <input type="file" class="form-control" name="product_pic" id="product_pic" accept=".jpg,.jpeg,.png,.gif">
                <small class="text-danger">[เฉพาะไฟล์ .jpg, .png, .gif เท่านั้น]</small>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success" type="submit">เพิ่มข้อมูลสินค้า</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">ยกเลิก</button>
    </div>
</form>
