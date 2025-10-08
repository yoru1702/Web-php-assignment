<?php
    session_start();
    
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';

    $type=$_POST["type"];
    if($type==""){
        $Data=getProduct($conn);
    }else{
        $sql="select * from tb_products where category_id='$type' order by product_id asc";
        $Data=mysqli_query( $conn,$sql);
    }
    $Num=mysqli_num_rows($Data);

    if($product_pic==""){
        $product_pic="no.png";
    }
    $Num=mysqli_num_rows($Data);
    
?>
<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php';?><br><br><br><br><br>
        <div class="container"><br>
            <center><h2><b>จัดการสินค้า</b></h2></center><br>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <a class="btn btn_add btn-primary">-&nbsp;&nbsp;&nbsp;&nbsp;เพิ่มสินค้า&nbsp;&nbsp;&nbsp;&nbsp;-</a><br><br>
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
            </div>
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
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($Data)):                         
                        $isActive = $row['is_active'];
                        $status_class = $isActive == 'Available' ? 'text-success' : 'text-danger';
                        $status_text = $isActive == 'Available' ? 'พร้อมขาย' : 'ไม่พร้อมขาย';
                    ?>
                    <tr align="center">
                        <td><?=$row['product_id']?></td>
                        <td>
                            <img src="../asset/img/product/<?=$row['product_pic']?>" class="rounded-pill" width="100"><br>
                            <?=$row['product_name']?>
                        </td>
                        <td>
                            <?=["1"=>"เครื่องดื่ม","2"=>"อาหารแห้ง","3"=>"ขนม","4"=>"ของใช้ส่วนตัว","5"=>"ผลิตภัณฑ์ทำความสะอาด","6"=>"เครื่องเขียน"][$row['category_id']] ?? "-"?>
                        </td>
                        <td><?=$row['product_num']?></td>
                        <td class="text-danger fw-bold"><?=number_format($row['cost_price'],2)?> ฿</td>
                        <td class="text-success fw-bold"><?=number_format($row['sell_price'],2)?> ฿</td>
                         <td class="<?= $status_class ?>"><b><?= $status_text ?></b></td>
                        <td>
                            <a class="btn btn-warning btn_edit" data-id="<?=$row['product_id']?>">แก้ไข</a>
                            <a class="btn btn-danger" href="delProduct.php?product_id=<?=$row['product_id']?>&product_pic=<?=$row['product_pic']?>" onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')">ลบ</a>
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
            let product_id = $(this).data("id");
            $.ajax({
                url:"editProduct.php",
                type:"POST",
                data:{ product_id: product_id },
                success:function(result){
                    $("#adm").html('');
                    $("#adm").html(result);
                    $("#am").modal('show');
                },
                error:function(error){
                    alert(error.responseText);
                },
            });
        });
    });

</script>
<div class="modal fade" id="am" role="dialog">
    <div class="modal-dialog modal-xl" role="document" id="adm"></div>
</div>