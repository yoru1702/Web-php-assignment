<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }
?>
<form action="addConfirm.php" enctype="multipart/form-data" onsubmit="return check()" method="post">
    <div class="modal-content" style="border-radius:30px">
        <div class="modal-header">
            <h2 class="modal-title"><b>เพิ่มพนักงาน</b></h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-sm-3">
                    <label class="form-label">ชื่อพนักงาน :</label>
                    <input type="text" class="form-control" name="name_user" id="name_user"
                        placeholder="กรอกชื่อพนักงาน" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">นามสกุล :</label>
                    <input type="text" step="0.01" class="form-control" name="sname_user" id="sname_user"
                        placeholder="กรอกนามสกุลพนักงาน" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Username :</label>
                    <input type="text" class="form-control" name="username" id="username"
                        placeholder="Username" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="กรอกรหัสผ่าน" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">เบอร์โทรติดต่อ :</label>
                    <input type="number" step="0.01" class="form-control" name="tel" id="tel"
                        placeholder="กรอกเบอร์โทรติดต่อ" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">ประเภทพนักงาน :</label>
                    <select name="role_id" id="role_id" class="form-select" required>
                        <option value="">--- เลือกประเภท ---</option>
                        <option value="1">Admin</option>
                        <option value="2">Staff</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-lg btn-success" type="submit" style="border-radius:30px">เพิ่มข้อมูล</button>
            <button class="btn btn-lg btn-danger" type="reset" style="border-radius:30px">ยกเลิก</button>
        </div>
    </div>
</form>