<?php
require_once('permission/access.php');
require_once('api/mystore.php');

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $pro_id = $_GET["id"];
    $sql = "SELECT pro_detail FROM products WHERE pro_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pro_id]);
    $row = $stmt->fetchObject();
} else {
    header("location:product.php");
    exit;
}
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
    <title>จัดการรายละเอียดสินค้า | ระบบจัดการข้อมูลหลังบ้าน</title>
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
                            <h1 class="m-0">จัดการรายละเอียดสินค้า</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">จัดการรายละเอียดสินค้า</li>
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
                            <form id="detailForm">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <div class="form-group row">
                                                <label>รหัสสินค้า</label>
                                                <input type="text" class="form-control" name="id" value="<?= $pro_id ?>" readonly>
                                            </div>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <textarea id="detail">
                                            <?= $row->pro_detail; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </form>

                            <div class="float-right">
                                <button type="button" class="btn btn-outline-danger mb-3" onclick="window.history.back()">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>ย้อนกลับ</span>
                                </button>
                                <button type="button" class="btn btn-outline-success mb-3" onclick="submit()">
                                    <i class="fas fa-edit"></i>
                                    <span>บันทึกรายละเอียด</span>
                                </button>
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
    <!-- CKEDITOR -->
    <script src="plugins/ckeditor/ckeditor.js"></script>

    <!-- Product Detail Function -->
    <script src="functions/product_detail.js"></script>
</body>

</html>