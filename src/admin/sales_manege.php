<?php
  $sql="SELECT * FROM tb_products WHERE is_active = 'Available'"; 
  $result=mysqli_query($conn,$sql);
  $sql1="select * from tb_category";
  $result1=mysqli_query($conn,$sql1);
  $num =0;
  $dis =0;
  $sum =0;
  $total =0;
?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;700&display=swap');
  body{
      font-family: "Prompt", sans-serif;
      font-weight: 300;
      font-style: normal;

      font-family: "Prompt", sans-serif;
      font-weight: 500;
      font-style: normal;
          /* background-image: url(../asset/img/background.png); */
  }
</style>
<div class="modal-dialog modal-xl">
    <div class="modal-content" style="border-radius: 30px 30px 0 0;">
        <div class="modal-header" style="border-radius: 28px 28px 0 0;background: #07c274;color: #fff;">
            <h3 class="modal-title"><b>ขายสินค้า</b></h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-lg-2 col-sm-2 col-12">
                <label><h5 class="m-2">ค้นหาสินค้า</h5></label>
              </div>
              <div class="col-lg-5 col-sm-5 col-12">
                <form class="d-flex">
                  <input class="form-control me-2" type="text" placeholder="กรุณากรอกสินค้า">
                  <button class="btn btn-primary" id="searchBtn" type="button">ค้นหา</button>
                </form>
              </div>
              <div class="col-lg-5 col-sm-5 col-12">
                <!-- เปลี่ยน option ให้ value เป็น category_id จริง -->
                <select name="sex" id="sex" class="form-select" required>
                  <option value="*">--- เลือกประเภทสินค้า ---</option>
                  <?php
                    while($read1=mysqli_fetch_assoc($result1)){
                      $category_id = $read1["category_id"];
                      $category_name = $read1["category_name"];
                  ?>
                    <option value="<?php echo $category_id; ?>"><?php echo $category_id . " : " . $category_name; ?></option>
                  <?php } ?>
                </select>

              </div>
            </div>
          </div><hr>

          <div class="container">
            <div class="row">
              <div class="col-lg-3 col-sm-3 col-12">
                <center>
                  <b>จำนวนสินค้าที่ท่านเลือก : </b> <h4><b style="color: #f78c00ff;"><?php echo "$num"; ?></b></h4>
                </center>
              </div>
              <div class="col-lg-3 col-sm-3 col-12">
                <center>
                  <b>ส่วนลด : </b> <h4><b style="color: #009b74ff;"><?php echo "$dis"; ?> %</b></h4>
                </center>
              </div>
              <div class="col-lg-3 col-sm-3 col-12">
                <center>
                  <b>ราคาทั้งหมด : </b> <h4><b style="color: #dd0055ff;"><?php echo "".number_format($total)." บาท"; ?></b></h4>
                </center>
              </div>
              <div class="col-lg-3 col-sm-3 col-12">
                <center>
                  <a href="#" class="btn btn-success m-2">คิดราคาสินค้า</a>
                </center>
              </div>
            </div><hr>
            <table class="table table-hover table-striped">
                <tr class="h5" align="center">
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาสินค้า</th>
                    <th>จำนวนสินค้า</th>
                    <th>เลือกสินค้า</th>
                    <th>กรอกจำนวน</th>
                    <th>ราคารวม</th>
                </tr>
                <?php
                    $i=1;
                    while($read=mysqli_fetch_assoc($result)){
                        $product_id   = $read["product_id"];
                        $product_name = $read["product_name"];
                        $sell_price   = $read["sell_price"];
                        $category_id   = $read["category_id"];
                        $is_active    = $read["is_active"];
                        $product_pic  = $read["product_pic"];
                        $product_num  = $read["product_num"];
                ?>
                <tr align="center"
                    data-category="<?php echo $category_id; ?>"
                    data-product-id="<?php echo $product_id; ?>">
                    <td><?php echo $product_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo number_format($sell_price) . " บาท"; ?></td>
                    <td><?php echo $product_num; ?></td>
                    <td>
                      <input type="checkbox" class="form-check-input select-checkbox" data-product-id="<?php echo $product_id; ?>">
                    </td>
                    <td style="width: 14%;">
                      <input type="number" min="0" class="form-control qty-input" data-product-id="<?php echo $product_id; ?>" placeholder="กรอกจำนวน">
                    </td>
                    <td class="row-total"><?php echo number_format($sum) . " บาท"; ?></td>
                </tr>

                <?php
                    $i++;
                    }
                ?>
            </table>
          </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('input[placeholder="กรุณากรอกสินค้า"]');
    const searchButton = document.querySelector('.btn.btn-primary');
    const categorySelect = document.getElementById('sex');
    const rows = document.querySelectorAll("table tr");

    // 🔍 ฟังก์ชันค้นหาด้วยรหัสสินค้า
    searchButton.addEventListener("click", function() {
        const searchValue = searchInput.value.trim();
        rows.forEach((row, index) => {
            if (index === 0) return; // ข้ามแถวหัวตาราง
            const codeCell = row.children[0];
            if (!codeCell) return;
            const code = codeCell.innerText.trim();

            if (searchValue === "" || code === searchValue) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // 📦 ฟังก์ชันกรองตามประเภทสินค้า
    categorySelect.addEventListener("change", function() {
        const selectedValue = categorySelect.value.trim();
        rows.forEach((row, index) => {
            if (index === 0) return;
            const categoryCell = row.children[0]; // ใช้รหัสสินค้าเป็นตัวเชื่อม
            if (!categoryCell) return;

            // ตรงนี้ถ้าพี่มีข้อมูล category_id ในแต่ละแถว
            // แนะนำเพิ่ม <td hidden> หรือ data-category เพื่อให้กรองได้แม่นยำ
            // สมมติว่าเราเพิ่ม data-category ลงใน <tr>
            const categoryAttr = row.getAttribute("data-category");

            if (selectedValue === "*" || selectedValue === categoryAttr) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('input[placeholder="กรุณากรอกสินค้า"]');
    const searchButton = document.getElementById('searchBtn');
    const categorySelect = document.getElementById('sex');
    const table = document.querySelector("table");
    if(!table) return;
    const rows = table.querySelectorAll("tr");

    function filterRows() {
        const rawSearch = searchInput.value.trim();
        const searchLower = rawSearch.toLowerCase();
        const selectedCategory = categorySelect.value.trim();

        rows.forEach((row, idx) => {
            if (idx === 0) return; // ข้าม header
            const productId = (row.dataset.productId || "").toString().trim();
            const productCategory = (row.dataset.category || "").toString().trim();
            const productName = (row.children[1] && row.children[1].innerText) ? row.children[1].innerText.trim().toLowerCase() : "";

            let matchSearch = true;
            if (rawSearch !== "") {
                if (productId.includes(rawSearch) || productName.includes(searchLower)) {
                    matchSearch = true;
                } else {
                    matchSearch = false;
                }
            }

            let matchCategory = true;
            if (selectedCategory !== "*" && selectedCategory !== "") {
                matchCategory = (productCategory === selectedCategory);
            }

            if (matchSearch && matchCategory) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // ✅ เมื่อกดปุ่มค้นหา
    searchButton.addEventListener("click", function() {
        // รีเซ็ต dropdown หมวดหมู่ให้กลับไปค่าแรก
        categorySelect.value = "*";
        filterRows();
    });

    // ✅ เมื่อพิมพ์ Enter ในช่องค้นหา
    searchInput.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            categorySelect.value = "*"; // รีเซ็ตหมวดหมู่
            filterRows();
        }
    });

    // ✅ เมื่อเลือกหมวดหมู่ ให้ล้างช่องค้นหาออก
    categorySelect.addEventListener("change", function() {
        searchInput.value = ""; // ล้างช่องค้นหา
        filterRows();
    });
});
</script>

<!-- คิดราคา -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const qtyInputs = document.querySelectorAll(".qty-input");
    const checkboxes = document.querySelectorAll(".select-checkbox");
    const totalItemsDisplay = document.querySelector("b[style*='#f78c00ff']").parentElement.querySelector("b");
    const totalPriceDisplay = document.querySelector("b[style*='#dd0055ff']").parentElement.querySelector("b");

    function formatNumber(num) {
        return num.toLocaleString("th-TH");
    }

    function calculateTotals() {
        let totalItems = 0;
        let grandTotal = 0;

        checkboxes.forEach(chk => {
            const row = chk.closest("tr");
            const qtyInput = row.querySelector(".qty-input");
            const rowTotalCell = row.querySelector(".row-total");
            const priceText = row.children[2].innerText.replace(" บาท", "").replace(/,/g, "");
            const price = parseFloat(priceText) || 0;
            const qty = parseFloat(qtyInput.value) || 0;

            // ✅ ถ้าเช็กถูกเลือก
            if (chk.checked && qty > 0) {
                const rowTotal = price * qty;
                rowTotalCell.innerText = formatNumber(rowTotal) + " บาท";
                totalItems += qty;
                grandTotal += rowTotal;
            } else {
                // ❌ ถ้ายังไม่เลือก (หรือจำนวน = 0)
                rowTotalCell.innerText = "0 บาท";
            }
        });

        totalItemsDisplay.innerText = totalItems;
        totalPriceDisplay.innerText = formatNumber(grandTotal) + " บาท";
    }

    // 🎯 เมื่อพิมพ์จำนวนสินค้า
    qtyInputs.forEach(input => {
        input.addEventListener("input", function() {
            calculateTotals();
        });
    });

    // ✅ เมื่อเลือก / ยกเลิกติ๊กสินค้า
    checkboxes.forEach(chk => {
        chk.addEventListener("change", function() {
            calculateTotals();
        });
    });
});
</script>
