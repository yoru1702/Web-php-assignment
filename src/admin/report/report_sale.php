<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/function.php';

if ($_SESSION["valid_admin"] == "") {
    echo "<meta http-equiv='refresh' content='0;url=/project_assignment/src/login.php'>";
    exit();
}

// ✅ รับค่าการกรองช่วงเวลา
$filter = $_GET['filter'] ?? 'all';
$where = "";

switch ($filter) {
    case 'day':
        $where = "WHERE DATE(s.sale_datetime) = CURDATE()";
        $title = "รายวัน";
        break;
    case 'week':
        $where = "WHERE YEARWEEK(s.sale_datetime, 1) = YEARWEEK(CURDATE(), 1)";
        $title = "รายสัปดาห์";
        break;
    case 'month':
        $where = "WHERE MONTH(s.sale_datetime) = MONTH(CURDATE()) AND YEAR(s.sale_datetime) = YEAR(CURDATE())";
        $title = "รายเดือน";
        break;
    case 'year':
        $where = "WHERE YEAR(s.sale_datetime) = YEAR(CURDATE())";
        $title = "รายปี";
        break;
    default:
        $title = "ทั้งหมด";
        break;
}

// ✅ ดึงข้อมูลยอดขายพร้อมคำนวณต้นทุน/รายได้/กำไร
$sql = "
    SELECT 
        s.sale_id,
        s.sale_no,
        s.user_id,
        s.sale_datetime,
        u.name_user,
        u.sname_user,
        SUM(p.cost_price * st.qty) AS total_cost,
        SUM(p.sell_price * st.qty) AS total_revenue,
        SUM((p.sell_price - p.cost_price) * st.qty) AS total_profit
    FROM tb_sales s
    JOIN tb_salestime st ON s.sale_id = st.sale_id
    JOIN tb_products p ON st.product_id = p.product_id
    LEFT JOIN tb_users u ON s.user_id = u.user_id
    $where
    GROUP BY s.sale_id, s.sale_no, s.user_id, s.sale_datetime, u.name_user, u.sname_user
    ORDER BY s.sale_id DESC
";
$res = mysqli_query($conn, $sql);
$Num = mysqli_num_rows($res);

// ✅ รวมรายได้/กำไรทั้งหมด
$sqlSum = "
    SELECT 
        SUM(p.cost_price * st.qty) AS total_cost,
        SUM(p.sell_price * st.qty) AS total_revenue,
        SUM((p.sell_price - p.cost_price) * st.qty) AS total_profit
    FROM tb_sales s
    JOIN tb_salestime st ON s.sale_id = st.sale_id
    JOIN tb_products p ON st.product_id = p.product_id
    $where
";
$sumRes = mysqli_query($conn, $sqlSum);
$sumRow = mysqli_fetch_assoc($sumRes);

$totalRevenue = $sumRow['total_revenue'] ?? 0;
$totalProfit = $sumRow['total_profit'] ?? 0;
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end bg-1">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/navbar.php'; ?>
    </div>

    <div class="col-lg-10 col-sm-10 col-12">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/src/admin/head.php'; ?>
        <br><br><br><br>

        <div class="container my-4">
            <center>
                <h2><b><i class="fa-solid fa-receipt"></i>&nbsp;รายงานยอดขายสินค้า (<?= $title ?>)</b></h2>
            </center><br>

            <!-- ปุ่มกรองช่วงเวลา -->
            <div class="d-flex justify-content-center mb-3 gap-2 flex-wrap">
                <a href="?filter=day" class="btn btn-outline-primary <?= $filter=='day'?'active':'' ?>">วันนี้</a>
                <a href="?filter=week" class="btn btn-outline-primary <?= $filter=='week'?'active':'' ?>">สัปดาห์นี้</a>
                <a href="?filter=month" class="btn btn-outline-primary <?= $filter=='month'?'active':'' ?>">เดือนนี้</a>
                <a href="?filter=year" class="btn btn-outline-primary <?= $filter=='year'?'active':'' ?>">ปีนี้</a>
                <a href="?filter=all" class="btn btn-outline-secondary <?= $filter=='all'?'active':'' ?>">ทั้งหมด</a>
            </div>

            <!-- สรุปรายได้ / กำไร -->
            <div class="row text-center mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-success">
                        <div class="card-body">
                            <h5 class="text-success">รายได้รวม</h5>
                            <h3 class="fw-bold"><?= number_format($totalRevenue, 2) ?> ฿</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary">
                        <div class="card-body">
                            <h5 class="text-primary">กำไรรวม</h5>
                            <h3 class="fw-bold"><?= number_format($totalProfit, 2) ?> ฿</h3>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($Num == 0): ?>
                <center><h2 class="text-danger"><b>ไม่พบข้อมูล</b></h2></center>
            <?php else: ?>
                <center>
                    <h4 class="text-primary"><b>ข้อมูล <?= $Num ?> รายการ</b></h4>
                </center><br><hr>

                <table class="table table-hover table-striped text-center align-middle">
                    <thead>
                        <tr>
                            <th>รหัสใบเสร็จ</th>
                            <th>พนักงานขาย</th>
                            <th>รายได้รวม</th>
                            <th>กำไร</th>
                            <th>วันที่ขาย</th>
                            <th>ดูใบเสร็จ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($res)): ?>
                            <tr>
                                <td><b>#<?= htmlspecialchars($row['sale_no']) ?></b></td>
                                <td><?= htmlspecialchars($row['name_user'] . ' ' . $row['sname_user']) ?></td>
                                <td class="text-success fw-bold"><?= number_format($row['total_revenue'], 2) ?> ฿</td>
                                <td class="text-primary fw-bold"><?= number_format($row['total_profit'], 2) ?> ฿</td>
                                <td><?= date("d/m/Y H:i", strtotime($row['sale_datetime'])) ?></td>
                                <td>
                                    <button 
                                        class="btn btn-sm btn-outline-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#receiptModal" 
                                        data-id="<?= $row['sale_id'] ?>" 
                                        data-code="<?= $row['sale_no'] ?>">
                                        <i class="fa-solid fa-file-invoice"></i> ดูใบเสร็จ
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal ใบเสร็จ -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa-solid fa-file-invoice"></i> ใบเสร็จการขาย</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="receiptContent">
        <center><i class="fa-solid fa-spinner fa-spin"></i> กำลังโหลด...</center>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const receiptModal = document.getElementById("receiptModal");
    receiptModal.addEventListener("show.bs.modal", function(event) {
        const button = event.relatedTarget;
        const saleId = button.getAttribute("data-id");
        const code = button.getAttribute("data-code");
        const modalBody = document.getElementById("receiptContent");

        modalBody.innerHTML = `<center><i class="fa-solid fa-spinner fa-spin"></i> กำลังโหลดใบเสร็จ #${code}...</center>`;

        fetch(`/project_assignment/src/admin/viewReceipt.php?sale_id=${saleId}`)
            .then(res => res.text())
            .then(html => modalBody.innerHTML = html)
            .catch(() => modalBody.innerHTML = `<div class='text-danger text-center'>เกิดข้อผิดพลาดในการโหลดข้อมูล</div>`);
    });
});
</script>
