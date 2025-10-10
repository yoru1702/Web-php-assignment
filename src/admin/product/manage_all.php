<?php
    session_start();
    include '../../../include/config.inc.php';
    include '../../../include/function.php';
    $sql="SELECT * FROM tb_products WHERE is_active = 'Available'"; 
    $result=mysqli_query($conn,$sql);
    $sql2="SELECT * FROM tb_users"; 
    $result2=mysqli_query($conn,$sql2);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include "head.php";?>
        <br><br><br><br><br> 
        <div class="container-fluid"><br>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-12">
                    <?php include "manage_sales.php"; ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <?php include "manage_form.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>