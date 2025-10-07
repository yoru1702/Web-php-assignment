<?php
  include "head.php";
?>
<br><br><br><br><br><br><br><br><br><br>
<div class="row">
    <div class="col-sm-4 col-lg-4 col-4"></div>
    <div class="col-lg-4 col-sm-4 col-4">
        <center>
            <h1><b>เข้าสู่ระบบ</b></h1><br>
            <form action="check_login.php" name="form1" method="post" style="border-radius:30px" class="border p-4">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" name="user" id="user" placeholder="Username" required>
                    <label class="floatinginput">Username</label>
                </div>
                <div class="form-floating mt-3">
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required>
                    <label class="floatinginput">Password</label>
                </div><br>
                <button class="btn btn-lg btn-success w-100" type="submit" style="border-radius:30px">เข้าสู่ระบบ</button>
            </form>
        </center>
    </div>
    <div class="col-sm-4 col-lg-4 col-4"></div>
</div>
<br><br><br><br><br><br><br><br><br><br>