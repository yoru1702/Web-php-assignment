<?php
session_start();
include '../../../include/config.inc.php';
include '../../../include/function.php';

$p = $_POST;
$user_id = $p['user_id'];

$sql = "SELECT * FROM tb_users WHERE user_id='$user_id'";
$read = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>

<form action="editConfirm.php" enctype="multipart/form-data" onsubmit="return check()" method="post">
    <div class="modal-content" style="border-radius:30px">
        <div class="modal-header">
            <h2 class="modal-title"><b>แก้ไขข้อมูลพนักงาน</b></h2>
            <?php echo $read['user_id'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-sm-3">
                    <label class="form-label">ชื่อพนักงาน :</label>
                    <input type="text" class="form-control" name="name_user" id="name_user"
                        placeholder="กรอกชื่อพนักงาน" value="<?= $read['name_user'] ?>" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">นามสกุล :</label>
                    <input type="text" step="0.01" class="form-control" name="sname_user" id="sname_user"
                        placeholder="กรอกนามสกุลพนักงาน" value="<?= $read['sname_user'] ?>" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Username :</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                        value="<?= $read['username'] ?>" required>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="กรอกรหัสผ่าน"
                        value="<?= $read['password'] ?>" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">เบอร์โทรติดต่อ :</label>
                    <input type="number" step="0.01" class="form-control" name="tel" id="tel"
                        placeholder="กรอกเบอร์โทรติดต่อ" value="<?= $read['tel'] ?>" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">ประเภทพนักงาน :</label>
                    <select name="role_id" id="role_id" class="form-select" required>
                        <option value="">--- เลือกประเภท ---</option>
                        <?php 
                                $role_id = $read['role_id'];
                                $sql2 = "SELECT * FROM tb_roles";
                                $result2 = mysqli_query($conn, $sql2);
                                while ($read2 = mysqli_fetch_assoc($result2)) {
                                    $role_id1 = $read2["role_id"];
                                    $role_name = $read2["role_name"];
                                    if ($role_id == $role_id1) {
                            ?>
                                        <option value="<?php echo $role_id; ?>" selected><?php echo $role_name; ?></option>
                            <?php   } else { ?>
                                        <option value="<?php echo $role_id1; ?>"><?php echo $role_name; ?></option>
                            <?php   } 
                                } 
                            ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-lg btn-warning" type="submit" style="border-radius:30px">แก้ไขข้อมูล</button>
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button class="btn btn-lg btn-danger" type="reset" style="border-radius:30px">ยกเลิก</button>
        </div>
    </div>
</form>