<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="../../../asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../../asset/js/bootstrap.bundle.min.js"></script>
    <script src="../../../asset/js/jquery-3.7.1.min.js"></script>
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
    width: 81%;
    box-shadow: 0px 0px 5px 2px;
    box-shadow: #000;
    justify-content: center;
    z-index: 999;
    background: linear-gradient(90deg,#108baa,#07c274);  /* ดำ */
    color: #fff;             /* ขาว */
}
</style>
<body>
<!-- Navbar start -->
    <nav class="navbar m-3 navbar-expand-sm" style="border-radius:50px;">
        <div class="container-fluid">
            <div class="navbar-nav">
                <div class="nav-item">
                    <a class="nav-link" href="index.php"><b style="color: #fff;font-size: 20px;">Home</b></a>
                </div>
            </div>
        </div>
        <ul class="navbar-nav me-auto">
        </ul>
        <ul class="navbar-nav">
            <div class="container">
                <li class="nav-link dropdown">
                    <a class="nav-link text-light dropdown-toggle" role="button" data-bs-toggle="dropdown" style="font-size: 20px;">
                        <?php echo "&nbsp;&nbsp;&nbsp;$_SESSION[name_user] $_SESSION[sname_user]"; ?>
                    </a>    
                    <ul class="dropdown-menu">
                        <li><a href="../logout.php" class="dropdown-item" onclick="return confirm('ท่านต้องการออกจากระบบใช่หรือไม่?')">ออกจากระบบ</a></li>
                    </ul>
                </li>
            </div>
        </ul>
    </nav>
    <!-- Navbar end -->
</body>
</html>