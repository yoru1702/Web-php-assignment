<?php
    session_start();
    include "../../include/config.inc.php";
    include "../../include/function.php";

    $Data = getUser($conn);
    $Num = mysqli_num_rows($Data);
?>

<link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
<link rel="stylesheet" href="../../asset/css/style.css">
<script src="../../asset/js/bootstrap.bundle.min.js"></script>
<script src="../../asset/js/jquery-3.7.min.js"></script>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include "navbar.php";?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <div class="container"><br>
            <center><h2><b>ข้อมูลพนักงาน</b></h2></center><br>
            <a class="btn btn_add btn-pirmary">เพิ่มข้อมูลพนักงาน</a>
            <form action="user.php" method="post">
                <div class="input-group">
                    <span class="input-group-text">ค้นหา</span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ค้นหา">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </form><br>
            <?php
                if($Num==0){
                    echo "<center><h2><b><font color='red'>ไม่พบข้อมูล</font></b></h2></center>";
                }else{
                    echo "<center><h2><b><font color='blue'>ข้อมูล $Num รายการ</font></b></h2></center>";
            ?><br>
            <table class="table table-holver table-striped">
                <tr align="center">
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เบอร์โทรติดต่อ</th>
                    <th>ตำแหน่ง</th>
                    <th>จัดการ</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($Data)) { ?>
                <tr align="center">
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['name_user'] . ' ' . $row['sname_user']; ?></td>
                    <td class="text-success" style="font-weight: bold;"><?php echo "".substr($row['tel'],0,3)."-".substr($row['tel'],3,7)."";?></td>
                    <td><?php echo ($row['role_id'] == 1) ? 'แอดมิน' : 'พนักงาน'; ?></td>
                    <td>
                        <a class="btn btn-warning btn-sm">แก้ไข</a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('ท่านต้องการลบข้อมูลใช่หรือไม่?')">ลบ</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php } ?>
        </div>
    </div>
</div>