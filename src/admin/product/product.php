<?php
    session_start();
    
    include '../../../include/config.inc.php';
    include '../../../include/function.php';

    $type=$_POST["type"];
    if($type==""){
        $Data=getProduct($conn);
    }else{
        $sql="select * from tb_products where category_id='$type' order by product_id asc";
        $Data=mysqli_query( $conn,$sql);
    }
    $Num=mysqli_num_rows($Data);
?>
<link rel="stylesheet" href="../../../asset/css/bootstrap.min.css">
<link rel="stylesheet" href="../../asset/css/style.css">
<script src="../../../asset/js/bootstrap.bundle.min.js"></script>
<script src="../../../asset/js/jquery-3.7.min.js"></script>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "../navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <div class="container"><br>
            <center><h2><b>จัดการสินค้า</b></h2></center><br>
            <div class="row">
                <div class="col-lg-1 col-sm-4"></div>
                <div class="col-lg-10 col-sm-4">
                    <a class="btn btn_add btn-primary">เพิ่มสินค้า</a>
                    <form action="product.php" method="post">
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
                <div class="col-lg-1 col-sm-4"></div>
            </div>
            <?php if($Num==0): ?>
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
                        <th>จัดการ</th>
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
                        <td class="text-danger"><?=number_format($row['cost_price'],2)?> ฿</td>
                        <td class="text-success fw-bold"><?=number_format($row['sell_price'],2)?> ฿</td>
                        <td>
                            <a class="btn btn-warning btn-sm">แก้ไข</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('ท่านต้องการลบข้อมูลใช่หรือไม่?')">ลบ</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php
                endif;
            ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(".btn_add").on('click',function(){
            $.ajax({
                url:"addProduct.php",
                type:"POST",
                success:function(result){
                    $("#adm").html('');
                    $("#adm").html(result);
                    $("#am").modal('show');
                },
                error:function(error){
                    alert(error.responsetext);
                },
            });
        });
    });
    $(function(){
        $(".btn_edit").on('click',function(){
            $.ajax({
                url:"editProduct.php",
                data:"product_id="+$(this).attr("product_id"),
                type:"POST",
                success:function(result){
                    $("#adm").html('');
                    $("#adm").html(result);
                    $("#am").modal('show');
                },
                error:function(error){
                    alert(error.responsetext);
                },
            });
        });
    });
</script>
<div class="modal fade" id="am" role="dialog">
    <div class="modal-dialog modal-xl" role="document" id="adm"></div>
</div>