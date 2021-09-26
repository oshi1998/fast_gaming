<?php

session_start();
if(isset($_SESSION['CUSTOMER_USERNAME']) && !empty($_SESSION['CUSTOMER_USERNAME'])){
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>ลงทะเบียน</title>

    <?php require_once('layouts/head.php'); ?>
</head>

<body class="sub_page">

    <div class="hero_area">
        <!-- header section strats -->
        <?php require_once('layouts/menu.php'); ?>
        <!-- end header section -->
    </div>

    <!-- why us section -->

    <section class="why_us_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    แบบฟอร์มลงทะเบียน
                </h2>
                <div id="showAlert"></div>
            </div>

            <div class="row d-flex justify-content-center">
                <div class="col-lg-4 col-12">
                    <form id="registerForm">
                        <div class="form-group">
                            <label>ชื่อจริง</label>
                            <input type="text" class="form-control" name="firstname">
                        </div>
                        <div class="form-group">
                            <label>นามสกุล</label>
                            <input type="text" class="form-control" name="lastname">
                        </div>
                        <div class="form-group">
                            <label>เพศ</label>
                            <select class="form-control" name="gender">
                                <option value="" selected disabled>--- เลือกเพศ ---</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อผู้ใช้งาน</label>
                            <input type="text" class="form-control" name="username" id="inputUsername" onchange="checkUsername(event.target.value)">
                        </div>
                        <div class="form-group">
                            <label>รหัสผ่าน</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>ยืนยันรหัสผ่าน</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>

                        <div class="form-group d-flex justify-content-between">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="acceptCheck" id="acceptCheck">
                                <label class="form-check-label">
                                    ยอมรับ ข้อกำหนดเงื่อนไข และ นโยบายส่วนบุคคล
                                </label>
                            </div>
                            <button type="button" class="btn btn-success" onclick="submitRegister()">
                                <i class="fa fa-edit"></i>
                                ลงทะเบียน
                            </button>

                        </div>
                        <a href="login.php">มีบัญชีอยู่แล้ว?</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="app/functions/register.js"></script>
</body>

</html>