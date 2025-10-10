<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }
    $user_id = $_SESSION['user_id'] ?? 0;

    $p = $_POST;
    $f = $_FILES['product_pic'];
    
    $sql = "INSERT INTO tb_products (
                product_name, category_id, cost_price, sell_price, product_pic, is_active, product_num
            ) VALUES (
                '{$p['product_name']}', 
                '{$p['category']}', 
                '{$p['cost_price']}', 
                '{$p['sell_price']}', 
                '', 
                'Available',
                '{$p['product_num']}'
            )";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $id = mysqli_insert_id($conn);
        if (!empty($f['tmp_name'])) {
            $ext = strtolower(strrchr($f['name'], '.'));
            if (in_array($ext, ['.jpg', '.png', '.gif', '.jpeg'])) {
                $fname = "p{$id}{$ext}";
                move_uploaded_file($f['tmp_name'], "asset/img/product/$fname");
                mysqli_query($conn, "UPDATE tb_products SET product_pic='$fname' WHERE product_id=$id");
            } else {
                echo "<center><font color='red'><h2><b>นามสกุลไฟล์ไม่ถูกต้อง (.jpg, .png, .gif เท่านั้น)</b></h2></font></center>";
                echo "<meta http-equiv='refresh' content='1;url=product.php'>";
                exit;
            }
        }
        $movement_type = "เพิ่มสินค้าใหม่";
        $qty_signed = '+';
        $note = mysqli_real_escape_string($conn, "เพิ่มสินค้า {$p['product_name']} จำนวน {$p['product_num']} ชิ้น");
        $created_at = date('Y-m-d H:i:s');

        $sql_log = "INSERT INTO tb_stock_movement (product_id, movement_type, qty_signed, note, user_id, created_at)
                    VALUES ('$id', '$movement_type', '$qty_signed', '$note', '$user_id', '$created_at')";
        mysqli_query($conn, $sql_log);
    }

    // แสดงผลลัพธ์
    $msg = $res ? "เพิ่มข้อมูลสำเร็จ" : "เพิ่มข้อมูลไม่สำเร็จ";
    $color = $res ? "green" : "red";

    echo "<center><font color='$color'><h2><b>$msg</b></h2></font></center>";
    echo "<meta http-equiv='refresh' content='1;url=product.php'>";
?>
