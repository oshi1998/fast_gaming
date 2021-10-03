<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
  $sql = "SELECT * FROM products WHERE pro_name LIKE :search OR pro_detail LIKE :search";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    'search' => "%$_GET[search_query]%"
  ]);
  $products = $stmt->fetchAll();

  if (empty($products)) {
    require_once('app/api/myproducts.php');
  }
} else {
  require_once('app/api/myproducts.php');
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

  <meta name="keywords" content="<?= $store->st_keywords ?>" />
  <meta name="description" content="<?= $store->st_description ?>" />
  <meta name="author" content="<?= $store->st_author ?>" />

  <title>สินค้าของเรา | <?= $store->st_name ?></title>

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
                <img src="app/images/products/<?= $product['pro_img'] ?>" alt="<?= $product['pro_detail'] ?>">
                <a href="javascript:void(0)" class="add_cart_btn" onclick="addCart('<?= $product['pro_id'] ?>')">
                  <span>
                    ซื้อสินค้า
                  </span>
                </a>
              </div>
              <div class="detail-box">
                <a href="product_detail.php?id=<?= $product['pro_id'] ?>">
                  <h5>
                    <?= $product['pro_name'] ?>
                  </h5>
                </a>
                <div class="product_info">
                  <h5>
                    <span>ราคา:</span> <?= number_format($product['pro_price'], 2) ?> บาท
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

  <script src="app/functions/cart.js"></script>
</body>

</html>