<?php
    // session_start();
    include "../include/config.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <link rel="stylesheet" href="../asset/css/bootstrap.min.css">
     <link rel="stylesheet" href="../asset/css/style.css">
     <script src="../asset/js/bootstrap.bundle.min.js"></script>
     <script src="../asset/js/jquery-3.7.min.js"></script>
     <!-- icon -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
/* สไตล์ navbar ปกติ */
.navbar {
    position: fixed; 
    top: 0;
    width: 97.5%;
    box-shadow: 0px 0px 5px 2px;
    box-shadow: #000;
    justify-content: center;
    transition: all 0.2s ease;
    z-index: 999;
    background: linear-gradient(90deg,#108baa,#07c274);  /* ดำ */
    color: #fff;             /* ขาว */
}
</style>
<body>
<!-- Navbar start -->
    <nav class="navbar m-4 navbar-expand-sm" style="border-radius:50px;">
        <div class="container-fluid mx-auto">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="../src/admin/index.php"><b style="color: #FFF;font-size: 20px;">Home</b></a>
                </li>
            </ul>
            <a class="navbar-brand" href="#" style="color: #FFF;"><h3><b>Store</b></h3></a>
        </div>
    </nav>
    <!-- Navbar end -->
</body>
</html>