<?php
require_once('permission/access.php');
require_once('api/mystore.php');
require_once('api/connect.php');


// รายการซื้อทั้งหมด
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username ORDER BY od_created DESC";
$stmt = $pdo->query($sql);
$od1 = $stmt->fetchAll();

// รายการซื้อ สถานะ รอชำระเงิน/กำลังตรวจสอบหลักฐานการโอนเงิน
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username AND od_status = ? OR od_status = ? ORDER BY od_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["รอชำระเงิน", "กำลังตรวจสอบหลักฐานการโอนเงิน"]);
$od2 = $stmt->fetchAll();

// รายการซื้อ สถานะ เตรียมจัดส่งสินค้า
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username AND od_status = ? ORDER BY od_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["เตรียมจัดส่งสินค้า"]);
$od3 = $stmt->fetchAll();

// รายการซื้อ สถานะ จัดส่งสินค้าเรียบร้อย
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username AND od_status = ? ORDER BY od_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["จัดส่งสินค้าเรียบร้อย"]);
$od4 = $stmt->fetchAll();

// รายการซื้อ สถานะ สำเร็จ
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username AND od_status = ? ORDER BY od_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["สำเร็จ"]);
$od5 = $stmt->fetchAll();

// รายการซื้อ สถานะ ยกเลิกแล้ว
$sql = "SELECT * FROM orders,customers WHERE orders.od_cus_username=customers.cus_username AND od_status = ? ORDER BY od_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["ยกเลิกแล้ว"]);
$od6 = $stmt->fetchAll();
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
    <title>รายการสั่งซื้อของลูกค้า | ระบบจัดการข้อมูลหลังบ้าน</title>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
                            <h1 class="m-0">รายการสั่งซื้อของลูกค้า</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">รายการสั่งซื้อของลูกค้า</li>
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
                        <div class="col-12">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">ทั้งหมด</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitpay-tab" data-toggle="pill" href="#pills-waitpay" role="tab" aria-controls="pills-waitpay" aria-selected="false">รอชำระ (<?= count($od2) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitdelivery-tab" data-toggle="pill" href="#pills-waitdelivery" role="tab" aria-controls="pills-waitdelivery" aria-selected="false">รอจัดส่ง (<?= count($od3) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitreceive-tab" data-toggle="pill" href="#pills-waitreceive" role="tab" aria-controls="pills-waitreceive" aria-selected="false">รอรับของ (<?= count($od4) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-success-tab" data-toggle="pill" href="#pills-success" role="tab" aria-controls="pills-success" aria-selected="false">สำเร็จ (<?= count($od5) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-cancel-tab" data-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false">ยกเลิก (<?= count($od6) ?>)</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                                    <?php foreach ($od1 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                            </div>
                                            <div class="card-footer">
                                                <?php if ($od['od_status'] != "รอชำระเงิน" && $od['od_status']!="ยกเลิกแล้ว" && $od['od_payment_method'] != "เก็บเงินปลายทาง") : ?>
                                                    <button class="btn btn-primary float-left ml-3" onclick="viewProof('<?= $od['od_id'] ?>')">หลักฐานการชำระเงิน</a>
                                                <?php endif ?>
                                                    <?php if ($od['od_status'] == "กำลังตรวจสอบหลักฐานการโอนเงิน") : ?>
                                                        <button class="btn btn-success float-left ml-3" onclick="acceptOrder('<?= $od['od_id'] ?>')">อนุมัติการชำระเงิน</a>
                                                        <button class="btn btn-danger float-left ml-3" onclick="cancelOrder('<?= $od['od_id'] ?>')">ปฏิเสธการชำระเงิน</a>
                                                    <?php elseif ($od['od_status'] == "เตรียมจัดส่งสินค้า") :  ?>
                                                        <button class="btn btn-success float-left ml-3" onclick="delivery('<?= $od['od_id'] ?>')">จัดส่งสินค้าเรียบร้อย</a>
                                                    <?php elseif ($od['od_status'] == "จัดส่งสินค้าเรียบร้อย") : ?>
                                                        <button class="btn btn-primary float-left ml-3" onclick="editDelivery('<?= $od['od_id'] ?>')">แก้ไขข้อมูลจัดส่ง</a>
                                                        <button class="btn btn-success float-left ml-3" onclick="successOrder('<?= $od['od_id'] ?>')">สำเร็จแล้ว</a>
                                                    <?php elseif ($od['od_status']=="รอชำระเงิน") : ?>
                                                        <button class="btn btn-danger float-left ml-3" onclick="cancelOrder('<?= $od['od_id'] ?>')">ยกเลิก</a>
                                                    <?php endif ?>
                                                    <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitpay" role="tabpanel" aria-labelledby="pills-waitpay-tab">
                                    <?php foreach ($od2 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-danger float-left ml-3" onclick="cancelOrder('<?= $od['od_id'] ?>')">ยกเลิก</a>
                                                <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitdelivery" role="tabpanel" aria-labelledby="pills-waitdelivery-tab">
                                    <?php foreach ($od3 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                            </div>
                                            <div class="card-footer">
                                                <?php if ($od['od_status'] != "รอชำระเงิน" && $od['od_payment_method'] != "เก็บเงินปลายทาง") : ?>
                                                    <button class="btn btn-primary float-left ml-3" onclick="viewProof('<?= $od['od_id'] ?>')">หลักฐานการชำระเงิน</a>
                                                <?php endif ?>
                                                    <?php if ($od['od_status'] == "กำลังตรวจสอบหลักฐานการโอนเงิน") : ?>
                                                        <button class="btn btn-success float-left ml-3" onclick="acceptOrder('<?= $od['od_id'] ?>')">อนุมัติการชำระเงิน</a>
                                                        <button class="btn btn-danger float-left ml-3" onclick="cancelOrder('<?= $od['od_id'] ?>')">ปฏิเสธการชำระเงิน</a>
                                                    <?php elseif ($od['od_status'] == "เตรียมจัดส่งสินค้า") :  ?>
                                                        <button class="btn btn-success float-left ml-3" onclick="delivery('<?= $od['od_id'] ?>')">จัดส่งสินค้าเรียบร้อย</a>
                                                    <?php endif ?>
                                                    <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitreceive" role="tabpanel" aria-labelledby="pills-waitreceive-tab">
                                    <?php foreach ($od4 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                            </div>
                                            <div class="card-footer">
                                                <?php if ($od['od_status'] != "รอชำระเงิน" && $od['od_payment_method'] != "เก็บเงินปลายทาง") : ?>
                                                    <button class="btn btn-primary float-left ml-3" onclick="viewProof('<?= $od['od_id'] ?>')">หลักฐานการชำระเงิน</a>
                                                <?php endif ?>
                                                    <?php if ($od['od_status'] == "จัดส่งสินค้าเรียบร้อย") : ?>
                                                        <button class="btn btn-primary float-left ml-3" onclick="editDelivery('<?= $od['od_id'] ?>')">แก้ไขข้อมูลจัดส่ง</a>
                                                        <button class="btn btn-success float-left ml-3" onclick="successOrder('<?= $od['od_id'] ?>')">สำเร็จแล้ว</a>
                                                    <?php endif ?>
                                                    <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                    <?php foreach ($od5 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                            </div>
                                            <div class="card-footer">
                                                <?php if ($od['od_status'] != "รอชำระเงิน" && $od['od_payment_method'] != "เก็บเงินปลายทาง") : ?>
                                                    <button class="btn btn-primary float-left ml-3" onclick="viewProof('<?= $od['od_id'] ?>')">หลักฐานการชำระเงิน</a>
                                                <?php endif ?>
                                                    <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
                                    <?php foreach ($od6 as $od) { ?>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <strong>ID: <?= $od['od_id'] ?></strong>
                                                <strong class="float-right">สถานะ: <?= $od['od_status'] ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <p>ชื่อลูกค้า: <?= $od['cus_firstname'] . " " . $od['cus_lastname'] ?></p>
                                                <p>ที่อยู่: <?= $od['cus_address'] ?></p>
                                                <p>เบอร์โทร: <?= $od['cus_phone'] ?></p>
                                                <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                <hr>
                                                <strong class="text-red">สาเหตุ: </strong> <?= $od['od_note'] ?>
                                            </div>
                                            <div class="card-footer">
                                               <button class="btn btn-info float-right" onclick="viewOrder('<?= $od['od_id'] ?>')">ดูคำสั่งซื้อ</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
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


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="myModalBody">
                    </div>
                </div>
            </div>
        </div>

        <!-- Include footer file -->
        <?php include_once('layouts/footer.php') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <!-- Order Function -->
    <script src="functions/order.js"></script>
</body>

</html>