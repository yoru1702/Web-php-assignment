<?php
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

$sale_id = $_GET['sale_id'] ?? 0;

// ดึงข้อมูลหัวใบเสร็จ
$sql = "
    SELECT s.sale_no, s.sale_datetime, u.name_user, u.sname_user
    FROM tb_sales s
    LEFT JOIN tb_users u ON s.user_id = u.user_id
    WHERE s.sale_id = '$sale_id'
";
$result = mysqli_query($conn, $sql);
$header = mysqli_fetch_assoc($result);

// ดึงรายการสินค้า
$sql2 = "
    SELECT p.product_name, st.qty, p.sell_price, (st.qty * p.sell_price) AS total
    FROM tb_salestime st
    JOIN tb_products p ON st.product_id = p.product_id
    WHERE st.sale_id = '$sale_id'
";
$result2 = mysqli_query($conn, $sql2);

$total = 0;
?>

<div class="modal-dialog modal-sm modal-dialog-centered">
  <div class="modal-content" style="border-radius: 25px; background-color: #fff; font-family: 'Prompt', sans-serif;">
    <div class="modal-body px-4 py-3">
      <div class="text-center mb-2">
        <h6 class="fw-bold mb-0">Store</h6>
        <hr class="my-2">
        <small>ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ</small><br>
        <small>TAX#000000000000 (VAT Included)</small><br>
        <small>Vat Code 00000 POS#ABC000000000000</small>
      </div>

      <hr class="my-2">

      <?php if ($header): ?>
        <div class="d-flex justify-content-between">
          <small>เลขที่ขาย: <?= htmlspecialchars($header['sale_no']) ?></small>
          <small><?= date("d/m/Y H:i", strtotime($header['sale_datetime'])) ?></small>
        </div>
        <small>พนักงาน: <?= htmlspecialchars($header['name_user'] . ' ' . $header['sname_user']) ?></small>

        <hr class="my-2">

        <table class="table table-borderless table-sm mb-1" style="font-size: 13px;">
          <tbody>
            <?php while($row = mysqli_fetch_assoc($result2)): ?>
              <tr>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td class="text-end"><?= $row['qty'] ?></td>
                <td class="text-end"><?= number_format($row['sell_price'], 2) ?> -</td>
              </tr>
              <?php $total += $row['total']; ?>
            <?php endwhile; ?>
          </tbody>
        </table>

        <hr class="my-2">
        <table class="w-100" style="font-size: 14px;">
          <tr>
            <td class="text-start fw-bold">รวมทั้งสิ้น</td>
            <td class="text-end fw-bold"><?= number_format($total, 2) ?> ฿</td>
          </tr>
          <tr>
            <td class="text-start">ส่วนลดพิเศษ</td>
            <td class="text-end">00.00 ฿</td>
          </tr>
          <tr>
            <td class="text-start fw-bold">ยอดสุทธิ</td>
            <td class="text-end fw-bold text-success"><?= number_format($total, 2) ?> ฿</td>
          </tr>
        </table>

        <hr class="my-2">
        <div class="text-center">
          <!-- <small>** บิลนี้ประหยัด 17.00 บาท **</small><br> -->
          <small>PayAtAll by Counter Service</small><br>
          <small>ขอบคุณที่ใช้บริการ 💚</small>
        </div>
      <?php else: ?>
        <div class="text-danger text-center">ไม่พบข้อมูลใบเสร็จนี้</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap');
    .table td, .table th { padding: 0.25rem; vertical-align: middle; }
    .modal-content { box-shadow: 0 0 10px rgba(0,0,0,0.2); }
    hr { border-top: 1px dashed #999; }
</style>
