<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/style.php';

$sql = "SELECT m.*, p.product_name, u.name_user, u.sname_user
        FROM tb_stock_movement m
        JOIN tb_products p ON m.product_id = p.product_id
        JOIN tb_users u ON m.user_id = u.user_id
        ORDER BY m.created_at DESC";

$result = mysqli_query($conn, $sql);
$Num = mysqli_num_rows($result);
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php'; ?>
    </div>
    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php';?><br><br><br><br><br>
        <div class="container my-4">
            <center>
                <h2><b>ประวัติการเคลื่อนไหวของสินค้า</b></h2>
                <hr>
            </center>

            <?php if ($Num == 0): ?>
                <center><h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2></center>
            <?php else: ?>
                <center><h4 class="text-primary">จำนวน <?= $Num ?> รายการ</h4></center>
                <table class="table table-hover table-striped mt-3 align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>สินค้า</th>
                            <th>ประเภทการเคลื่อนไหว</th>
                            <th>สัญลักษณ์</th>
                            <th>รายละเอียด</th>
                            <th>ผู้ทำรายการ</th>
                            <th>วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr align="center">
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['product_name']) ?></td>
                            <td>
                                <?php
                                    $color = match($row['qty_signed']) {
                                        '+' => 'success',
                                        '-' => 'danger',
                                        default => 'secondary'
                                    };
                                ?>
                                <span class="badge bg-<?= $color ?>">
                                    <?= htmlspecialchars($row['movement_type']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-<?= $color ?>"><?= $row['qty_signed'] ?></td>
                            <td><?= htmlspecialchars($row['note']) ?></td>
                            <td><?= htmlspecialchars($row['name_user'] . ' ' . $row['sname_user']) ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
