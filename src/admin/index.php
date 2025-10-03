<?php
    session_start();

    include "../../include/config.inc.php";
    include "../../include/function.php";
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
            <h2><b>Dashboard</b></h2><hr><br>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">ยอดขายวันนี้</div>
                        <div class="card-body">
                            <h5 class="card-title text-success">1500 บาท</h5>
                            <p class="card-text text-white">ข้อมูล ณ วันที่ 1 มิถุนายน 2567</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">จำนวนสินค้าในคลัง</div>
                        <div class="card-body">
                            <h5 class="card-title">1500 รายการ</h5>
                            <p class="card-text">ข้อมูล ณ วันที่ 1 มิถุนายน 2567</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">จำนวนสินค้าในคลัง</div>
                        <div class="card-body">
                            <h5 class="card-title">1500 รายการ</h5>
                            <p class="card-text">ข้อมูล ณ วันที่ 1 มิถุนายน 2567</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">จำนวนสินค้าในคลัง</div>
                        <div class="card-body">
                            <h5 class="card-title">1500 รายการ</h5>
                            <p class="card-text">ข้อมูล ณ วันที่ 1 มิถุนายน 2567</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- กราฟวงกลม -->
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="card-header">สัดส่วนสินค้าในคลัง</div>
                        <div class="card-body">
                            <canvas id="productChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// กราฟแท่ง แสดงยอดขายรายเดือน
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
        datasets: [{
            label: 'ยอดขาย (บาท)',
            data: [12000, 19000, 15000, 20000, 17000, 25000],
            backgroundColor: 'rgba(25, 135, 84, 0.8)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// กราฟวงกลม แสดงสัดส่วนสินค้า
const ctx2 = document.getElementById('productChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['อาหารเสริม', 'อุปกรณ์', 'ยา', 'อื่นๆ'],
        datasets: [{
            data: [40, 25, 20, 15],
            backgroundColor: [
                'rgba(25, 135, 84, 0.8)',
                'rgba(13, 110, 253, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true
    }
});
</script>