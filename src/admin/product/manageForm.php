<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

$current_user_id = $_SESSION['user_id'] ?? 1;

// ✅ ดึงเฉพาะข้อมูลการเบิกสินค้า (movement_type = 'เบิกสินค้า')
$sql = "
    SELECT
        sm.created_at,
        sm.qty_signed,
        sm.note,
        p.product_name,
        u.name_user,
        u.sname_user
    FROM tb_stock_movement sm
    JOIN tb_products p ON sm.product_id = p.product_id
    JOIN tb_users u ON sm.user_id = u.user_id
    WHERE sm.movement_type IN ('เบิกสินค้า', 'เบิกออก')
    ORDER BY sm.created_at DESC
";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card" style="border-radius:30px 30px 0 0;">
    <div class="card-header" style="border-radius:30px 30px 0 0;background: #07c274;color: #fff;">
        <center><h3><b>แสดงรายการตัดสินค้าออกคลัง</b></h3></center>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr align="center">
                        <th>ลำดับ</th>
                        <th>วันที่/เวลาเบิก</th>
                        <th>สินค้า</th>
                        <th>จำนวน (ชิ้น)</th>
                        <th>ผู้เบิก</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            // 🔹 ดึงจำนวนจากข้อความ note (ถ้ามี)
                            $qty_match = [];
                            preg_match('/จำนวน (\d+) ชิ้น/', $row['note'], $qty_match);
                            $display_qty = $qty_match[1] ?? 'N/A';
                    ?>
                    <tr align="center">
                        <td><?= $counter++; ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'])); ?></td>
                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                        <td class="text-danger"><b><?= $display_qty; ?></b></td>
                        <td><?= htmlspecialchars($row['name_user'] . ' ' . $row['sname_user']); ?></td>
                        <td><?= htmlspecialchars($row['note']); ?></td>
                    </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            **ยังไม่มีรายการตัดสินค้าออกจากคลัง**
                        </td>
                    </tr>
                    <?php
                    endif;
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
