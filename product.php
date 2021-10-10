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

  $search_row = $stmt->fetchAll();

  if (empty($search_row)) {
    $empty_pro = "ไม่พบสินค้า $_GET[search_query]";
    require_once('app/api/myproducts.php');
  } else {
    $products = $search_row;
  }
} else if (isset($_GET['type']) && !empty($_GET['type'])) {
  $sql = "SELECT * FROM products WHERE pro_type = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_GET['type']]);
  $products = $stmt->fetchAll();

  if (empty($products)) {
    require_once('app/api/myproducts.php');
  }
} else {
  require_once('app/api/myproducts.php');
}

//Select ประเภทสินค้า

$sql = "SELECT * FROM product_types";
$stmt = $pdo->query($sql);
$types = $stmt->fetchAll();

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

    <div class="float-left p-5 position-fixed">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action">
          <strong>เมนูสินค้า</strong>
        </a>
        <a href="product.php" class="list-group-item list-group-item-action <?= (!isset($_GET["type"]) && empty($search_row)) ? "active" : "" ?>">ทั้งหมด</a>
        <?php foreach ($types as $type) { ?>
          <a href="product.php?type=<?= $type['pt_id'] ?>" class="list-group-item list-group-item-action <?= (isset($_GET["type"]) && $_GET["type"] == $type["pt_id"]) ? "active" : "" ?>"><?= $type['pt_name'] ?></a>
        <?php } ?>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="heading_container heading_center">
            <h2>
              สินค้าของเรา
            </h2>
            <?php if (isset($empty_pro) && !empty($empty_pro)) : ?>
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $empty_pro; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif ?>
          </div>
          <div class="row">
            <?php if (isset($_GET["type"]) && !empty($_GET["type"]) || isset($_GET["search_query"]) && !empty($search_row)) : ?>
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
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php else : ?>
              <div class="row">
                <?php foreach ($types as $type) { ?>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <?= $type["pt_name"] ?>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <?php foreach ($products as $product) { ?>
                            <?php if ($product['pro_type'] == $type['pt_id']) : ?>
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
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endif ?>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <br><hr>
                  </div>
                <?php } ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- end product section -->


  <?php require_once('layouts/footer.php'); ?>

  <script src="app/functions/cart.js"></script>
</body>

</html>