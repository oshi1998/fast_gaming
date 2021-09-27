<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');
require_once('app/api/myproducts.php');
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

  <title>Minics</title>

  <?php require_once('layouts/head.php'); ?>
</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
    <?php require_once('layouts/menu.php'); ?>
    <!-- end header section -->
  </div>


  <!-- product section -->

  <section class="product_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          สินค้าของเรา
        </h2>
      </div>
      <div class="row">
        <?php foreach ($products as $product) { ?>
          <div class="col-sm-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="app/images/products/<?= $product['pro_img'] ?>" alt="">
                <a href="javasript:void(0)" class="add_cart_btn">
                  <span>
                    เพิ่มลงตะกร้า
                  </span>
                </a>
              </div>
              <div class="detail-box">
                <h5>
                  <?= $product['pro_name'] ?>
                </h5>
                <div class="product_info">
                  <h5>
                    <span>ราคา:</span> <?= number_format($product['pro_price']) ?>
                  </h5>
                  <div class="star_container">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- end product section -->


  <?php require_once('layouts/footer.php'); ?>


</body>

</html>