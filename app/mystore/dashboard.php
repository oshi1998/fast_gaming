<?php
require_once('permission/access.php');
require_once('api/mystore.php');
require_once('api/connect.php');

// นับจำนวน

$today = date("Y-m-d");

$sql = "SELECT (SELECT count(*) FROM customers) as num_cus,
(SELECT count(*) FROM products) as num_pro,
(SELECT count(*) FROM employees) as num_emp,
(SELECT count(*) FROM orders WHERE DATE(od_created)='$today') as num_od";
$stmt = $pdo->query($sql);
$count = $stmt->fetchObject();


?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แดชบอร์ด | ระบบจัดการข้อมูลหลังบ้าน</title>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini" onload="getStats()">
    <div class="wrapper">

        <!-- Include Navigator file -->
        <?php include_once('layouts/navigator.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ยินดีต้อนรับ <strong class="text-red"><?= $_SESSION['ADMIN_FIRSTNAME'] . " " . $_SESSION['ADMIN_LASTNAME']; ?></strong> สู่ระบบจัดการข้อมูลหลังร้าน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">แดชบอร์ด</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <a href="order.php">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>+<?= $count->num_od; ?></h3>
                                        <p>ออเดอร์วันนี้</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-cart-plus"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6">
                            <a href="customer.php">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?= $count->num_cus; ?></h3>
                                        <p>ลูกค้า</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6">
                            <a href="employee.php">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?= $count->num_emp; ?></h3>
                                        <p>พนักงาน</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6">
                            <a href="product.php">
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3><?= $count->num_pro ?></h3>
                                        <p>สินค้า</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-gamepad"></i>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-lg-12">
                            <div class="card card-white">
                                <div class="card-header">
                                    <h3 class="card-title">ข้อมูลยอดขายสินค้า 6 เดือนหลังสุด (ตามประเภทสินค้า)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Include footer file -->
        <?php include_once('layouts/footer.php') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <script src="functions/dashboard.js"></script>
</body>

</html>