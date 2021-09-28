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
    <title>ตั้งค่าร้าน | ระบบจัดการข้อมูลหลังร้าน</title>
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

<body class="hold-transition sidebar-mini" onload="read()">
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
                            <h1 class="m-0">ตั้งค่าร้าน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">ตั้งค่าร้าน</li>
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
                        <div class="col-lg-4">
                            <div class="card">

                                <div class="card-header">
                                    ข้อมูลพื้นฐานร้าน
                                </div>

                                <div class="card-body">
                                    <form id="form1">
                                        <div class="form-group">
                                            <label>ชื่อร้าน</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                        </div>

                                        <div class="form-group">
                                            <label>ที่อยู่ร้าน</label>
                                            <textarea class="form-control" name="address" id="address"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>เบอร์โทรร้าน</label>
                                            <input type="text" class="form-control" name="phone" id="phone">
                                        </div>

                                        <div class="form-group">
                                            <label>อีเมลร้าน</label>
                                            <input type="email" class="form-control" name="email" id="email">
                                        </div>

                                        <div class="form-group">
                                            <label>โลโก้ร้าน</label><br>
                                            <img class="img-size-64 mb-3" id="preview_logo">
                                            <input type="file" class="form-control" name="logo" accept="image/*" onchange="readFile(event)">
                                            <input type="text" class="form-control" name="old_logo" id="old_logo" readonly hidden>
                                        </div>

                                        <div class="form-group float-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm1()">
                                                <i class="fas fa-edit">บันทึก</i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="card">

                                <div class="card-header">
                                    ช่องทางการติดตามอื่นๆ
                                </div>

                                <div class="card-body">
                                    <form id="form2">
                                        <div class="form-group">
                                            <label>Facebook (URL)</label>
                                            <input type="text" class="form-control" name="facebook" id="facebook">
                                        </div>

                                        <div class="form-group">
                                            <label>Twitter (URL)</label>
                                            <input type="text" class="form-control" name="twitter" id="twitter">
                                        </div>

                                        <div class="form-group">
                                            <label>Instagram (URL)</label>
                                            <input type="text" class="form-control" name="ig" id="ig">
                                        </div>

                                        <div class="form-group">
                                            <label>Youtube (URL)</label>
                                            <input type="text" class="form-control" name="youtube" id="youtube">
                                        </div>

                                        <div class="form-group">
                                            <label>ID Line</label>
                                            <input type="text" class="form-control" name="line" id="line">
                                        </div>

                                        <div class="form-group float-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm2()">
                                                <i class="fas fa-edit">บันทึก</i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">

                                <div class="card-header">
                                    SEO Meta Tags
                                </div>

                                <div class="card-body">
                                    <form id="form3">
                                        <div class="form-group">
                                            <label>Description (คำอธิบายเว็บไซต์)</label>
                                            <textarea class="form-control" name="description" id="description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Keywords (คำค้นหา เช่น ราคาถูก,อุปกรณ์คอม,การ์ดจอ เป็นต้น)</label>
                                            <textarea class="form-control" name="keywords" id="keywords"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Author (ผู้เขียน)</label>
                                            <input type="text" class="form-control" name="author" id="author">
                                        </div>

                                        <div class="form-group float-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm3()">
                                                <i class="fas fa-edit">บันทึก</i>
                                            </button>
                                        </div>
                                    </form>
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

    <!-- Store Function -->
    <script src="functions/store.js"></script>
</body>

</html>