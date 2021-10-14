<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
  $sql = "SELECT * FROM products WHERE pro_status=0 AND pro_name LIKE :search OR pro_detail LIKE :search";
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
  $sql = "SELECT * FROM products WHERE pro_status=0 AND pro_type = ?";
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

  <?php include("layouts/head.php"); ?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
      -webkit-text-shadow: rgba(0, 0, 0, .01) 0 0 1px;
      text-shadow: rgba(0, 0, 0, .01) 0 0 1px
    }

    div {
      display: block;
      position: relative;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box
    }

    .bbb_viewed {
      padding-top: 51px;
      padding-bottom: 60px;
      background: #eff6fa
    }

    .bbb_main_container {
      background-color: #fff;
      padding: 11px
    }

    .bbb_viewed_title_container {
      border-bottom: solid 1px #dadada
    }

    .bbb_viewed_title {
      margin-bottom: 16px;
      margin-top: 8px
    }

    .bbb_viewed_nav_container {
      position: absolute;
      right: -5px;
      bottom: 14px
    }

    .bbb_viewed_nav {
      display: inline-block;
      cursor: pointer
    }

    .bbb_viewed_nav i {
      color: #dadada;
      font-size: 18px;
      padding: 5px;
      -webkit-transition: all 200ms ease;
      -moz-transition: all 200ms ease;
      -ms-transition: all 200ms ease;
      -o-transition: all 200ms ease;
      transition: all 200ms ease
    }

    .bbb_viewed_nav:hover i {
      color: #606264
    }

    .bbb_viewed_prev {
      margin-right: 15px
    }

    .bbb_viewed_slider_container {
      padding-top: 13px
    }

    .bbb_viewed_item {
      width: 100%;
      background: #FFFFFF;
      border-radius: 2px;
      padding-top: 25px;
      padding-bottom: 25px;
      padding-left: 30px;
      padding-right: 30px
    }

    .bbb_viewed_image {
      width: 150px;
      height: 150px
    }

    .bbb_viewed_image img {
      display: block;
      max-width: 100%
    }

    .bbb_viewed_content {
      width: 100%;
      margin-top: 25px
    }

    .bbb_viewed_price {
      font-size: 16px;
      color: #000000;
      font-weight: 500
    }

    .bbb_viewed_item.discount .bbb_viewed_price {
      color: #df3b3b
    }

    .bbb_viewed_price span {
      position: relative;
      font-size: 12px;
      font-weight: 400;
      color: rgba(0, 0, 0, 0.6);
      margin-left: 8px
    }

    .bbb_viewed_price span::after {
      display: block;
      position: absolute;
      top: 6px;
      left: -2px;
      width: calc(100% + 4px);
      height: 1px;
      background: #8d8d8d;
      content: ''
    }

    .bbb_viewed_name {
      margin-top: 3px
    }

    .bbb_viewed_name a {
      font-size: 14px;
      color: #000000;
      -webkit-transition: all 200ms ease;
      -moz-transition: all 200ms ease;
      -ms-transition: all 200ms ease;
      -o-transition: all 200ms ease;
      transition: all 200ms ease
    }

    .bbb_viewed_name a:hover {
      color: #0e8ce4
    }

    .item_marks {
      position: absolute;
      top: 18px;
      left: 18px
    }

    .item_mark {
      display: none;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      color: #FFFFFF;
      font-size: 10px;
      font-weight: 500;
      line-height: 36px;
      text-align: center
    }

    .item_discount {
      background: #df3b3b;
      margin-right: 5px
    }

    .item_new {
      background: #0e8ce4
    }

    .bbb_viewed_item.discount .item_discount {
      display: inline-block
    }

    .bbb_viewed_item.is_new .item_new {
      display: inline-block
    }
  </style>
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

          <?php if (isset($_GET["type"]) && !empty($_GET["type"]) || isset($_GET["search_query"]) && !empty($search_row)) : ?>
            <div class="row">
              <?php foreach ($products as $product) { ?>
                <div class="col-sm-6 col-lg-4">
                  <div class="box">
                    <div class="img-box">
                      <img src="app/images/products/<?= $product['pro_img'] ?>">
                      <?php if ($product['pro_qty'] == 0) : ?>
                        <a class="add_cart_btn" disabled>
                          <span>
                            สินค้าหมด
                          </span>
                        </a>
                      <?php else : ?>
                        <a href="javascript:void(0)" class="add_cart_btn" onclick="addCart('<?= $product['pro_id'] ?>')">
                          <span>
                            ซื้อสินค้า
                          </span>
                        </a>
                      <?php endif ?>
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
            </div>
          <?php else : ?>
            <div class="bbb_viewed">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <?php foreach ($types as $type) { ?>
                      <div class="bbb_main_container">
                        <div class="bbb_viewed_title_container">
                          <h3 class="bbb_viewed_title"><?= $type["pt_name"] ?></h3>
                        </div>
                        <div class="bbb_viewed_slider_container">
                          <div class="owl-carousel owl-theme bbb_viewed_slider">
                            <?php foreach ($products as $product) { ?>
                              <?php if ($product["pro_type"] == $type["pt_id"]) : ?>
                                <div class="owl-item">
                                  <div class="box">
                                    <div class="img-box">
                                      <img src="app/images/products/<?= $product['pro_img'] ?>">
                                      <?php if ($product['pro_qty'] == 0) : ?>
                                        <a class="add_cart_btn" disabled>
                                          <span>
                                            สินค้าหมด
                                          </span>
                                        </a>
                                      <?php else : ?>
                                        <a href="javascript:void(0)" class="add_cart_btn" onclick="addCart('<?= $product['pro_id'] ?>')">
                                          <span>
                                            ซื้อสินค้า
                                          </span>
                                        </a>
                                      <?php endif ?>
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
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif ?>

        </div>
      </div>

    </div>
  </section>

  <!-- end product section -->


  <?php require_once('layouts/footer.php'); ?>
  <script src="app/functions/cart.js"></script>

  <script>
    $(document).ready(function() {

      if ($('.bbb_viewed_slider').length) {

        var viewedSlider = $('.bbb_viewed_slider');

        viewedSlider.owlCarousel({
          loop: true,
          margin: 30,
          autoplay: true,
          autoplayTimeout: 3000,
          nav: false,
          dots: false,
          responsive: {
            0: {
              items: 1
            },
            575: {
              items: 2
            },
            768: {
              items: 3
            },
            991: {
              items: 4
            },
            1199: {
              items: 6
            }
          }
        });

        if ($('.bbb_viewed_prev').length) {
          var prev = $('.bbb_viewed_prev');
          prev.on('click', function() {
            viewedSlider.trigger('prev.owl.carousel');
          });
        }

        if ($('.bbb_viewed_next').length) {
          var next = $('.bbb_viewed_next');
          next.on('click', function() {
            viewedSlider.trigger('next.owl.carousel');
          });
        }
      }


    });
  </script>
</body>

</html>