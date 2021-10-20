<?php
require_once('permission/access.php');
require_once('permission/onlyowner.php');
require_once('api/mystore.php');
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
    <title>รายงาน | ระบบจัดการข้อมูลหลังบ้าน</title>
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
                            <h1 class="m-0">รายงานทั่วไป</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">รายงาน</li>
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
                            <ul>
                                <li>
                                    <a target="_blank" href="show_report.php?report=allempnow">รายชื่อพนักงานปัจจุบัน (ทั้งหมด)</a>
                                </li>
                                <li>
                                    <a target="_blank" href="show_report.php?report=allempout">ราชื่อพนักงานที่พ้นสภาพ (ทั้งหมด)</a>
                                </li>
                                <li>
                                    <a target="_blank" href="show_report.php?report=allcus">รายชื่อลูกค้า (ทั้งหมด)</a>
                                </li>
                                <li>
                                    <a target="_blank" href="show_report.php?report=allproducts">รายการสินค้า (ทั้งหมด)</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="m-0">รายงานยอดขาย</h2>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <ul>
                                <li>
                                    <a target="_blank" href="show_report.php?report=saletoday">ยอดขายวันนี้</a>
                                </li>
                                <li>
                                    <a target="_blank" href="show_report.php?report=sale7day">ยอดขาย 7 วันหลังสุด</a>
                                </li>
                                <li>
                                    <a target="_blank" href="show_report.php?report=sale30day">ยอดขาย 30 วันหลังสุด</a>
                                </li>
                            </ul>

                            <div class="card">
                                <div class="card-header bg-info">
                                    เรียกดูรายงานยอดขาย ตามช่วงวันที่ เริ่มต้น-สิ้นสุด
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-form-label">เริ่มต้น</label>
                                        <div class="col-2">
                                            <input type="date" class="form-control" name="start">
                                        </div>
                                        <label class="col-form-label">สิ้นสุด</label>
                                        <div class="col-2">
                                            <input type="date" class="form-control" name="end">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success" onclick="findSaleReport()">ค้นหา</button>
                                        </div>
                                    </div>
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
            <div class="modal-dialog" role="document">
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


    <script>
        function findSaleReport() {
            let start = $('input[name="start"]').val();
            let end = $('input[name="end"]').val();

            if (start == "" || start == null) {
                swal({
                    title: "กรุณาเลือกวันที่เริ่มต้น",
                    icon: "error"
                }).then(() => {
                    $('input[name="start"]').focus();
                    return false;
                });
            } else if (end == "" || end == null) {
                swal({
                    title: "กรุณาเลือกวันที่สิ้นสุด",
                    icon: "error"
                }).then(() => {
                    $('input[name="end"]').focus();
                    return false;
                });
            } else {
                window.open(`show_report.php?report=salerange&start=${start}&end=${end}`,'_blank');
            }
        }
    </script>
</body>

</html>