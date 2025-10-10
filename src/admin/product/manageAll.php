<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';
    $sql="SELECT * FROM tb_products WHERE is_active = 'Available'"; 
    $result=mysqli_query($conn,$sql);
    $sql2="SELECT * FROM tb_users"; 
    $result2=mysqli_query($conn,$sql2);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php';?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php';?>
        <br><br><br><br><br> 
        <div class="container-fluid"><br>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-12">
                    <?php include "manageSales.php"; ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <?php include "manageForm.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>