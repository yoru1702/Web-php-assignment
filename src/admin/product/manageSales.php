<div class="card" style="border-radius:30px;">
    <div class="card-header" style="background: #108baa;border-radius:29px 29px 0 0;color: #fff;">
        <center><h3><b>ตัดรายการสินค้าออกคลัง</b></h3></center>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <label>วันที่ปัจจุบัน :</label>
                    <input type="date" class="form-control m-2" name="*" id="dateField" readonly>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <label>รหัสสินค้า : <label style="color: #ff0000ff;">(ใช้ในกรณี กรอกสินค้าแล้วหาไม่เจอ)</label></label>
                    <input type="text" class="form-control m-2" id="ProductSelect" placeholder="กรอกรหัสสินค้า">
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <label>เลือกรหัสสินค้า :</label>
                    <select name="product" id="productSelect" class="form-select m-2" required>
                        <option value="">== เลือกรหัสสินค้า ==</option>
                        <?php
                            while($read = mysqli_fetch_assoc($result)) {
                                $product_id   = $read["product_id"];
                                $product_name = $read["product_name"];
                                $sell_price   = $read["sell_price"];
                        ?>
                            <option 
                                value="<?php echo $product_id; ?>"
                                data-name="<?php echo htmlspecialchars($product_name); ?>"
                                data-price="<?php echo htmlspecialchars($sell_price); ?>"
                            >
                                รหัสสินค้า : <?php echo $product_id; ?> (<?php echo $product_name; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <label>ชื่อสินค้า :</label>
                    <input type="text" class="form-control m-2" id="productName" placeholder="ชื่อสินค้า" readonly>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <label>ราคาสินค้า :</label>
                    <input type="text" class="form-control m-2" id="productPrice" placeholder="ราคาสินค้า" readonly>
                </div>
                <div class="col-lg-9 col-sm-9 col-12">
                    <label>จำนวนสินค้าที่ต้องการ :</label>
                    <input type="text" class="form-control m-2 w-100" name="num" id="num" placeholder="กรอกจำนวนสินค้า">
                </div>
                <div class="col-lg-3 col-sm-3 col-12">
                    <br>
                    <button class="btn w-100 m-2" type="button" style="background: #07c274;color: #fff; " onclick="cal_num7()">คลิก คำนวณราคา</button>
                </div>
                <div class="col-lg-12 col-sm-12 col-12">
                    <label style="color: #ff0000ff;">( ใช้ในกรณีที่ต้องการจำนวนสินค้าตามปุ่มนี้เท่านั้น!!! )</label>
                    <div class="row m-2">
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num1" id="num1" value="1" onchange="cal_num1()">&nbsp;5 ชิ้น
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num2" id="num2" value="2" onchange="cal_num2()">&nbsp;10 ชิ้น
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num3" id="num3" value="3" onchange="cal_num3()">&nbsp;15 ชิ้น
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num4" id="num4" value="4" onchange="cal_num4()">&nbsp;20 ชิ้น
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num5" id="num5" value="5" onchange="cal_num5()">&nbsp;25 ชิ้น
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <input type="radio" class="form-check-input" name="num6" id="num6" value="6" onchange="cal_num6()">&nbsp;30 ชิ้น
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-12">
                    <label><h4><b>ราคาสุทธิ :</b></h4></label>
                    <input type="hidden" id="productPrice" value="<?php echo $productPrice; ?>">
                    <input type="text" class="form-control bg-dark text-warning" name="total" id="total" value="<?php echo "$total"; ?>" style="text-align:right;font-size:25px" placeholder="กรุณา *เลือกรหัสสินค้า* ก่อน *เลือกจำนวนสินค้า*" readonly><hr>
                </div>
                <div class="col-lg-12 col-sm-12 col-12">
                    <label><h4><b>หมายเหตุ :</b></h4></label>
                    <textarea class="form-control m-2" name="note" id="note" rows="3" placeholder="ระบุหมายเหตุ เช่น เบิกสินค้าไปหน้าร้าน A"></textarea>
                </div>
                <label><h4><b>ข้อมูลพนักงาน :</b></h4></label>
                <div class="col-lg-12 col-sm-12 col-12">
                    <label>เลือกรหัสพนักงาน :</label></label>
                    <select name="Name" id="NameSelect" class="form-select m-2" required>
                        <option value="">== เลือกรหัสพนักงาน ==</option>
                        <?php
                            while($read2 = mysqli_fetch_assoc($result2)) {
                                $user_id    = $read2["user_id"];
                                $name_user  = $read2["name_user"];
                                $sname_user = $read2["sname_user"];
                        ?>
                            <option 
                                value="<?php echo $user_id; ?>"
                                data-name="<?php echo htmlspecialchars($name_user); ?>"
                                data-sname="<?php echo htmlspecialchars($sname_user); ?>"
                            >
                                รหัส <?php echo $user_id; ?> : <?php echo $name_user . " " . $sname_user; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <form action="manageConfirm.php" method="post" id="confirmForm" onsubmit="return prepareAndSubmit()">
                    <button class="btn w-100 m-2 bg-primary" type="submit" style="color: #fff;">
                        <b>ตัดรายการสินค้าออกคลัง</b>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
  // สร้างวันที่ปัจจุบัน
  const today = new Date();

  // แปลงเป็นรูปแบบ YYYY-MM-DD เพื่อให้ตรงกับ input type="date"
  const formattedDate = today.toISOString().split('T')[0];

  // กำหนดค่าให้ input
  document.getElementById('dateField').value = formattedDate;
</script>

<!-- ค้นหาสินค้า -->
<script>
document.getElementById('productSelect').addEventListener('change', function() {
    // ดึง option ที่ถูกเลือก
    const selectedOption = this.options[this.selectedIndex];
    
    // ดึงค่าจาก data attribute
    const name = selectedOption.getAttribute('data-name');
    const price = selectedOption.getAttribute('data-price');
    
    // แสดงผลในกล่อง input
    document.getElementById('productName').value = name || '';
    document.getElementById('productPrice').value = price ? price + ' บาท' : '';
});
</script>
<script>
    document.querySelector('input#ProductSelect').addEventListener('input', function() {
        const inputCode = this.value.trim();
        const productOptions = document.querySelectorAll('select#ProductSelect option');

        let found = false;
        productOptions.forEach(option => {
            if (option.value === inputCode) {
                // ดึงข้อมูลชื่อและราคา
                const name = option.getAttribute('data-name');
                const price = option.getAttribute('data-price');

                document.getElementById('productName').value = name || '';
                document.getElementById('productPrice').value = price ? price + ' บาท' : '';

                found = true;
            }
        });

        if (!found) {
            document.getElementById('productName').value = '';
            document.getElementById('productPrice').value = '';
        }
    });
</script>


<!-- ค้นหาพนักงาน -->
<!-- <script>
    document.getElementById('NameSelect').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const fname = selected.getAttribute('data-name');
        const lname = selected.getAttribute('data-sname');

        document.getElementById('firstName').value = fname || '';
        document.getElementById('lastName').value = lname || '';
    });
</script> -->


<!-- คำนวณราคาสินค้า -->
<script>
    function cal_num1(){
        var num1=document.getElementById("num1").value;
        document.getElementById("num2").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num6").checked=false;
        if(num1=="1"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*5;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num2(){
        var num2=document.getElementById("num2").value;
        document.getElementById("num1").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num6").checked=false;
        if(num2=="2"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*10;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num3(){
        var num3=document.getElementById("num3").value;
        document.getElementById("num2").checked=false;
        document.getElementById("num1").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num6").checked=false;
        if(num3=="3"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*15;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num4(){
        var num4=document.getElementById("num4").value;
        document.getElementById("num2").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num1").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num6").checked=false;
        if(num4=="4"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*20;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num5(){
        var num5=document.getElementById("num5").value;
        document.getElementById("num2").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num1").checked=false;
        document.getElementById("num6").checked=false;
        if(num5=="5"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*25;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num6(){
        var num6=document.getElementById("num6").value;
        document.getElementById("num2").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num1").checked=false;
        if(num6=="6"){
            var productPrice=parseInt(document.getElementById("productPrice").value);
            var total=productPrice*30;
                document.getElementById("total").value = total.toFixed(2) + " บาท";

        }else{
            document.form1.productPrice.disabled=false;
            // document.form1.coin_pro.disabled=false;
        }
    }
    function cal_num7() {
        document.getElementById("num1").checked=false;
        document.getElementById("num2").checked=false;
        document.getElementById("num3").checked=false;
        document.getElementById("num4").checked=false;
        document.getElementById("num5").checked=false;
        document.getElementById("num6").checked=false;
        // ดึงราคาสินค้า
        var productPrice = parseFloat(document.getElementById("productPrice").value);
        // ดึงจำนวนสินค้าที่ผู้ใช้กรอก
        var num = parseInt(document.getElementById("num").value);

        // ตรวจสอบว่ากรอกเลขหรือยัง
        if (isNaN(num) || num <= 0) {
            alert("กรุณากรอกจำนวนสินค้าที่ถูกต้อง");
            return;
        }

        // คำนวณราคารวม
        var total = productPrice * num;

        // แสดงผลในช่องราคาสุทธิ
        document.getElementById("total").value = total.toFixed(2) + " บาท";
    }
</script>
<script>
    function prepareAndSubmit() {
        const form = document.getElementById('confirmForm');

        // 1. ดึงค่าสินค้าที่ถูกเลือก (product)
        const product_id = document.getElementById('productSelect').value;
        if (!product_id) {
            alert("กรุณาเลือกรหัสสินค้า");
            return false; // ป้องกันการ Submit
        }

        // 2. ดึงค่าจำนวน (num)
        let num = document.getElementById('num').value;
        if (!num || isNaN(parseInt(num)) || parseInt(num) <= 0) {
            alert("กรุณากรอกจำนวนสินค้าที่ถูกต้อง");
            return false;
        }

        // 3. ดึงค่าราคารวม (total)
        let total_text = document.getElementById('total').value;
        // ลบคำว่า " บาท" ออก
        let total = total_text.replace(' บาท', '');
        if (!total) {
             alert("กรุณาคลิก 'คำนวณราคา' ก่อนส่งข้อมูล");
             return false;
        }

        // 4. ดึงค่าหมายเหตุ (note)
        const note = document.getElementById('note').value;

        // **สร้าง Hidden Fields ใหม่ (หรือใช้ Hidden Fields เดิม แล้วกำหนดค่า)**
        // ในกรณีนี้ เราจะสร้าง Hidden Field ในฟอร์มแบบไดนามิก เพื่อให้มั่นใจว่าข้อมูลถูกส่ง
        
        // ล้าง Hidden Fields เก่า (ถ้ามี)
        form.innerHTML = '';
        
        // ฟังก์ชันสร้าง Hidden Input
        const createHiddenInput = (name, value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        };
        
        // กำหนดค่าและเพิ่ม Hidden Fields
        form.appendChild(createHiddenInput('product', product_id));
        form.appendChild(createHiddenInput('num', num));
        form.appendChild(createHiddenInput('total', total));
        form.appendChild(createHiddenInput('note', note));

        // ตรวจสอบ user_id จากการเลือกรหัสพนักงาน (ถ้าต้องการส่ง user_id จากฟอร์มนี้)
        const user_id = document.getElementById('NameSelect').value;
        if (user_id) {
             form.appendChild(createHiddenInput('user_id', user_id));
        }
        
        // คืนค่า true เพื่อให้ฟอร์มทำการ submit
        return true;
    }
</script>