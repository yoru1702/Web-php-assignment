<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/style.php';
    if($_SESSION["valid_admin"]==""){
        echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
        exit();
    }

    $search = $_POST['name'] ?? '';
    $Data = getUser($conn, $search);
    $Num = mysqli_num_rows($Data);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php'; ?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php'; ?><br><br><br><br>
        <div class="container my-4">
            <center>
                <h2><b>ข้อมูลพนักงาน</b></h2>
            </center><br>
            <a class="btn btn-primary btn_add mb-3">-&nbsp;&nbsp;&nbsp;&nbsp;เพิ่มข้อมูลพนักงาน&nbsp;&nbsp;&nbsp;&nbsp;-</a>
            <form action="user.php" method="post" class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">ค้นหา</span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ค้นหา"
                        value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </form>
            <?php if ($Num == 0): ?><br>
                <center>
                    <h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2>
                </center>
            <?php else: ?>
                <center>
                    <h2 class="text-primary"><b>ข้อมูล <?= $Num ?> รายการ</b></h2>
                </center><br><hr><br>
                <table class="table table-hover table-striped mt-3">
                    <tr align="center">
                        <th>รหัสพนักงาน</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เบอร์โทรติดต่อ</th>
                        <th>ตำแหน่ง</th>
                        <th>จัดการ</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($Data)): ?>
                        <tr align="center">
                            <td><?= $row['user_id'] ?></td>
                            <td><?= $row['name_user'] . ' ' . $row['sname_user'] ?></td>
                            <td class="text-success fw-bold"><?= substr($row['tel'], 0, 3) . "-" . substr($row['tel'], 3, 7) ?></td>
                            <td><?= $row['role_id'] == 1 ? 'แอดมิน' : 'พนักงาน' ?></td>
                            <td>
                                <a class="btn btn-warning btn_edit" data-id="<?=$row['user_id']?>">แก้ไข</a>
                            <a class="btn btn-danger" href="delUser.php?user_id=<?=$row['user_id']?>" onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(".btn_add").on('click',function(){
            $.ajax({
                url:"addUser.php",
                type:"POST",
                success:function(result){
                    $("#adm").html('');
                    $("#adm").html(result);
                    $("#am").modal('show');
                },
                error:function(error){
                    alert(error.responsetext);
                },
            });
        });
    });
    $(function(){
        $(".btn_edit").on('click',function(){
            let user_id = $(this).data("id");
            $.ajax({
                url:"editUser.php",
                type:"POST",
                data:{ user_id: user_id },
                success:function(result){
                    $("#adm").html('');
                    $("#adm").html(result);
                    $("#am").modal('show');
                },
                error:function(error){
                    alert(error.responseText);
                },
            });
        });
    });

</script>
<div class="modal fade" id="am" role="dialog">
    <div class="modal-dialog modal-xl" role="document" id="adm"></div>
</div>