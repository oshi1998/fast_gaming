<?php


session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (isset($_SESSION['CUSTOMER_USERNAME']) && !empty($_SESSION['CUSTOMER_USERNAME'])) {
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

  <title>เข้าสู่ระบบ</title>

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
          เข้าสู่ระบบ
        </h2>
        <div id="showAlert"></div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-12">
          <form id="loginForm">
            <div class="form-group">
              <input type="text" class="form-control text-center" name="username" placeholder="ชื่อผู้ใช้งาน">
            </div>
            <div class="form-group">
              <input type="password" class="form-control text-center" name="password" placeholder="รหัสผ่าน">
            </div>
            <div class="form-group text-center">
              <button type="button" class="btn btn-success btn-block" onclick="submitLogin()">เข้าสู่ระบบ</button><br>
              <a href="register.php">ต้องการลงทะเบียนใช้งาน?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- end why us section -->

  <?php require_once('layouts/footer.php'); ?>

  <script src="app/functions/login.js"></script>
</body>

</html>