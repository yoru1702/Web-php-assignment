<?php
    ini_set('session.cookie_path', '/');
    session_start();
    ob_start(); // เริ่มเก็บ output buffer
    include "../../include/config.inc.php";
    $sql="select distinct(role_id) from tb_roles";
    $result=mysqli_query($conn,$sql);
    include "../../include/function.php";

    $search = $_POST['name'] ?? '';
    $Data = getUser($conn, $search);
    $Num = mysqli_num_rows($Data);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include "head.php";?>
        <br><br><br><br><br>
        <div class="container my-4">
            <center><h2><b>ข้อมูลพนักงาน</b></h2></center>
            <a class="btn btn-primary mb-3">-&nbsp;&nbsp;&nbsp;&nbsp;เพิ่มข้อมูลพนักงาน&nbsp;&nbsp;&nbsp;&nbsp;-</a>
            <form action="user.php" method="post" class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">ค้นหา</span>
                    <input type="text" name="name" class="form-control" placeholder="ค้นหา" value="<?=htmlspecialchars($search)?>">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </form>
            <?php if($Num==0): ?>
                <center><h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2></center>
            <?php else: ?>
                <center><h2 class="text-primary"><b>ข้อมูล <?=$Num?> รายการ</b></h2></center>
                <table class="table table-hover table-striped mt-3">
                    <tr align="center">
                        <th>รหัสพนักงาน</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เบอร์โทรติดต่อ</th>
                        <th>ตำแหน่ง</th>
                        <th>จัดการ</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($Data)): ?>
                    <tr align="center">
                        <td><?=$row['user_id']?></td>
                        <td><?=$row['name_user'].' '.$row['sname_user']?></td>
                        <td class="text-success fw-bold"><?=substr($row['tel'],0,3)."-".substr($row['tel'],3,7)?></td>
                        <td><?=$row['role_id']==1?'แอดมิน':'พนักงาน'?></td>
                        <td>
                            <a class="btn btn-warning btn-sm">แก้ไข</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('ท่านต้องการลบข้อมูลใช่หรือไม่?')">ลบ</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
