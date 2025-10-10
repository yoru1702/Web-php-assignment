<?php
ini_set('session.cookie_path', '/');
session_start();
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/project_assignment/include/config.inc.php';

// ดึงหมวดหมู่
$sql2 = "SELECT * FROM tb_category";
$result2 = mysqli_query($conn, $sql2);

// ✅ ดึงข้อมูลสินค้าหน้าร้านจาก tb_products โดยตรง
$sql1 = "
    SELECT 
        p.product_id,
        p.product_name,
        p.product_pic,
        p.category_id,
        p.cost_price,
        p.sell_price,
        p.stock_qty
    FROM tb_products p
    WHERE p.is_active = 'Available'
    ORDER BY p.product_id ASC
";
$result1 = mysqli_query($conn, $sql1);
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap');
  body { font-family: "Prompt", sans-serif; }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-2 col-sm-2 col-12 border-end">
      <?php include "navbar.php"; ?>
    </div>

    <div class="col-lg-10 col-sm-10 col-12">
      <?php include "head.php"; ?>
      <br><br><br><br><br>
      <h1 class="text-center"><b>ขายสินค้า</b></h1>
      <hr>

      <!-- ✅ ส่วนค้นหา -->
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-2 col-sm-3 col-12">
            <label><h5 class="m-2">ค้นหาสินค้า</h5></label>
          </div>
          <div class="col-lg-5 col-sm-5 col-12">
            <div class="d-flex">
              <input class="form-control me-2" type="text" placeholder="กรุณากรอกชื่อสินค้า" id="searchBox">
              <button class="btn btn-primary" id="searchBtn" type="button">ค้นหา</button>
            </div>
          </div>
          <div class="col-lg-5 col-sm-4 col-12">
            <select id="categoryFilter" class="form-select">
              <option value="*">--- เลือกประเภทสินค้า ---</option>
              <?php while ($read2 = mysqli_fetch_assoc($result2)) { ?>
                <option value="<?= $read2['category_id'] ?>">
                  <?= $read2['category_id'] . " : " . $read2['category_name'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <hr>

      <form id="sellForm" method="post" action="processSale.php">
        <div class="container-fluid">
          <div class="row">
            <!-- ✅ ตารางสินค้า -->
            <div class="col-lg-8 col-sm-8 col-12 border-end">
              <div class="row text-center mb-3">
                <div class="col-lg-3"><b>จำนวนสินค้าที่เลือก:</b><h4 id="countSel" class="text-warning">0</h4></div>
                <div class="col-lg-3"><b>ราคาก่อนภาษี:</b><h4 id="subtotalDisplay" class="text-primary">0.00 บาท</h4></div>
                <div class="col-lg-3"><b>ภาษีมูลค่าเพิ่ม:</b><h4 id="vatDisplay" class="text-success">7%</h4></div>
                <div class="col-lg-3"><b>ราคาสุทธิ:</b><h4 id="totalPrice" class="text-danger">0.00 บาท</h4></div>
              </div>

              <table class="table table-hover table-striped text-center align-middle">
                <thead class="table-primary">
                  <tr>
                    <th>รูป</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาขาย</th>
                    <th>จำนวนคงเหลือ</th>
                    <th>เลือก</th>
                    <th>กรอกจำนวน</th>
                    <th>ราคารวม</th>
                  </tr>
                </thead>
                <tbody id="productTable">
                  <?php while ($row = mysqli_fetch_assoc($result1)): ?>
                    <tr data-category="<?= $row['category_id'] ?>" data-name="<?= htmlspecialchars($row['product_name']) ?>">
                      <td>
                        <img src="/project_assignment/asset/img/product/<?= $row['product_pic'] ?: 'no.jpg' ?>" width="70" height="70" style="object-fit:cover;border-radius:8px;">
                      </td>
                      <td><?= $row['product_name'] ?></td>
                      <td><?= number_format($row['sell_price'], 2) ?> ฿</td>
                      <td><?= number_format($row['stock_qty']) ?> ชิ้น</td>
                      <td><input type="checkbox" class="form-check-input select-checkbox" name="selected[]" value="<?= $row['product_id'] ?>"></td>
                      <td style="width:14%">
                        <input type="number" min="0" max="<?= $row['stock_qty'] ?>" name="qty[<?= $row['product_id'] ?>]" class="form-control qty-input text-center" placeholder="จำนวน">
                        <input type="hidden" name="price[<?= $row['product_id'] ?>]" value="<?= $row['sell_price'] ?>">
                      </td>
                      <td class="row-total">0 บาท</td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>

            <!-- ✅ กล่องคิดเงิน -->
            <div class="col-lg-4 col-sm-4 col-12">
              <center><h2><b>คิดเงิน / ทอนเงิน</b></h2></center><hr>
              <div class="row g-2">
                <div class="col-4 text-end"><h5>ราคาทั้งหมด:</h5></div>
                <div class="col-8"><input type="text" class="form-control bg-dark text-white" id="totalRight" readonly></div>

                <div class="col-4 text-end"><h5>รับเงิน:</h5></div>
                <div class="col-8"><input type="number" class="form-control bg-dark text-white" id="money" placeholder="จำนวนเงินที่รับมา"></div>

                <div class="col-4 text-end"><h5>เงินทอน:</h5></div>
                <div class="col-8"><input type="text" class="form-control bg-dark text-warning" id="change" readonly></div>

                <div class="col-12 mt-3">
                  <button type="submit" class="btn btn-lg w-100" style="background:#108baa;color:#fff;">
                    <b>คิดราคาสินค้า</b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ SCRIPT คำนวณทั้งหมด -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const qtyInputs = document.querySelectorAll(".qty-input");
  const checkboxes = document.querySelectorAll(".select-checkbox");

  const totalItemsDisplay = document.querySelector("#countSel");
  const vatDisplay = document.querySelector("#vatDisplay");
  const subtotalDisplay = document.querySelector("#subtotalDisplay");
  const totalPriceDisplay = document.querySelector("#totalPrice");

  const totalInputRight = document.getElementById("totalRight");
  const moneyInput = document.getElementById("money");
  const changeInput = document.getElementById("change");

  const vatRate = 7;

  function formatNumber(num) {
    return num.toLocaleString("th-TH", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function calculateTotals() {
    let totalItems = 0, subtotal = 0;

    checkboxes.forEach(chk => {
      const row = chk.closest("tr");
      const qtyInput = row.querySelector(".qty-input");
      const rowTotalCell = row.querySelector(".row-total");
      const stockQty = parseFloat(row.children[3].innerText.replace(" ชิ้น", "").replace(/,/g, "")) || 0;
      const priceText = row.children[2].innerText.replace("฿", "").replace(/,/g, "").trim();
      const price = parseFloat(priceText) || 0;
      const qty = parseFloat(qtyInput.value) || 0;

      if (qty > stockQty) {
        alert(`สินค้า "${row.children[1].innerText}" มีเพียง ${stockQty} ชิ้นเท่านั้น!`);
        qtyInput.value = stockQty;
        return;
      }

      if (chk.checked && qty > 0) {
        const rowTotal = price * qty;
        rowTotalCell.innerText = formatNumber(rowTotal) + " บาท";
        totalItems += qty;
        subtotal += rowTotal;
      } else {
        rowTotalCell.innerText = "0 บาท";
      }
    });

    const vatAmount = subtotal * vatRate / 100;
    const grandTotal = subtotal + vatAmount;

    totalItemsDisplay.innerText = totalItems;
    subtotalDisplay.innerText = `${formatNumber(subtotal)} บาท`;
    vatDisplay.innerText = `${vatRate}% (${formatNumber(vatAmount)} บาท)`;
    totalPriceDisplay.innerText = `${formatNumber(grandTotal)} บาท`;
    totalInputRight.value = formatNumber(grandTotal) + " บาท";

    calculateChange(grandTotal);
  }

  function calculateChange(grandTotal) {
    const money = parseFloat(moneyInput.value) || 0;
    const change = money - grandTotal;
    if (money > 0 && change >= 0)
      changeInput.value = formatNumber(change) + " บาท";
    else if (money > 0 && change < 0)
      changeInput.value = "เงินไม่พอ!";
    else
      changeInput.value = "0.00 บาท";
  }

  qtyInputs.forEach(i => i.addEventListener("input", calculateTotals));
  checkboxes.forEach(c => c.addEventListener("change", calculateTotals));
  moneyInput.addEventListener("input", () => {
    const total = parseFloat(totalInputRight.value.replace(/[^\d.]/g, "")) || 0;
    calculateChange(total);
  });

  // ✅ กรองหมวดหมู่
  const categoryFilter = document.getElementById("categoryFilter");
  categoryFilter.addEventListener("change", () => {
    const selected = categoryFilter.value;
    document.querySelectorAll("#productTable tr").forEach(row => {
      row.style.display = (selected === "*" || row.dataset.category === selected) ? "" : "none";
    });
  });

  // ✅ ค้นหาสินค้า
  const searchBox = document.getElementById("searchBox");
  document.getElementById("searchBtn").addEventListener("click", () => {
    const keyword = searchBox.value.toLowerCase();
    document.querySelectorAll("#productTable tr").forEach(row => {
      const name = row.dataset.name.toLowerCase();
      row.style.display = name.includes(keyword) ? "" : "none";
    });
  });
});
</script>
