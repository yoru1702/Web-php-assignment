<?php
    session_start();
    include "../../include/config.inc.php";
    include "../../include/function.php";

?>

<link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
<link rel="stylesheet" href="../../asset/css/style.css">
<script src="../../asset/js/bootstrap.bundle.min.js"></script>
<script src="../../asset/js/jquery-3.7.min.js"></script>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <div class="container"><br>
            <center><h2><b>จัดการสินค้า</b></h2></center><br>
            <div class="row">
                <div class="col-lg-1 col-sm-4"></div>
                <div class="col-lg-10 col-sm-4">
                    <a class="btn btn_add btn-pirmary">เพิ่มรสินค้า</a>
                    <form action="product.php" method="post">
                        <div class="input-group">
                            <span class="input-group-text">ค้นหา</span>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ค้นหา">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </form><br>
                </div>
                <div class="col-lg-1 col-sm-4"></div>
            </div>
            <?php
                if($Num==0){
                    echo "<center><h2><b><font color='red'>ไม่พบข้อมูล</font></b></h2></center>";
                }else{
                    echo "<center><h2><b><font color='blue'>ข้อมูล $Num รายการ</font></b></h2></center>";
            ?><br>
            <table class="table table-holver table-striped">
                <tr align="center">
                    <th width="50%">รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ต้นทุน</th>
                    <th>ราคาขาย</th>
                    <th>จัดการ</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($Data)) { ?>
                <?php } ?>
            </table>
            <?php } ?>
        </div>
    </div>
</div>