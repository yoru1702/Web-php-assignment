<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
/* สไตล์ navbar ปกติ */
.navbar {
    position: fixed; 
    top: 0;
    width: 80%;
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
                        <li><a href="/project_assignment/src/logout.php" class="dropdown-item" onclick="return confirm('ท่านต้องการออกจากระบบใช่หรือไม่?')">ออกจากระบบ</a></li>
                    </ul>
                </li>
            </div>
        </ul>
    </nav>
    <!-- Navbar end -->
</body>
</html>
