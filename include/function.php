<?php
    include 'config.inc.php';

    function getUser($conn){
        $sql = "SELECT * FROM tb_users order by user_id asc";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function getProduct($conn){
        $sql = "SELECT * FROM tb_products order by product_id asc";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
?>