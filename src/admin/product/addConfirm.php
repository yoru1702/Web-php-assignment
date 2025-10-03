<?php
    session_start();
    include '../../../include/config.inc.php';

    $p = $_POST;
    $f = $_FILES['product_pic'];
    $sql = "INSERT INTO tb_products VALUES (NULL,'$p[product_name]','$p[category]','$p[cost_price]','$p[sell_price]',NULL,'','$p[product_num]')";
    $res = mysqli_query($conn, $sql);

    if ($res && $f['tmp_name']) {
        $ext = strtolower(strrchr($f['name'], '.'));
        if (in_array($ext, ['.jpg', '.png', '.gif'])) {
            $id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(product_id) AS id FROM tb_products"))['id'];
            $fname = "$id$ext";
            move_uploaded_file($f['tmp_name'], "product/$fname");
            mysqli_query($conn, "UPDATE tb_products SET product_pic='$fname' WHERE product_id=$id");
        } else {
            echo "<center><font color='red'><h2><b>นามสกุลเอกสารไม่ถูกต้อง</b></h2></font></center>";
            echo "<meta http-equiv='refresh' content='1;url=product.php'>";
            exit;
        }
    }

    $msg = $res ? "เพิ่มข้อมูลสำเร็จ" : "เพิ่มข้อมูลไม่สำเร็จ";
    $color = $res ? "green" : "red";
    echo "<center><font color='$color'><h2><b>$msg</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=product.php'>";
?>