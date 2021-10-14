<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (!isset($_SESSION['CUSTOMER_USERNAME']) && empty($_SESSION['CUSTOMER_USERNAME'])) {
    header("location:login.php");
} else {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Select Product Record
        $sql = "SELECT * FROM products,product_types,brands 
        WHERE products.pro_type=product_types.pt_id
        AND products.pro_brand=brands.brand_id
        AND pro_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetchObject();
    } else {
        header("location:product.php");
    }
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

    <title>ติดต่อเรา | <?= $store->st_name ?></title>

    <?php require_once('layouts/head.php'); ?>
</head>

<body class="sub_page" onload="updateView('<?= $product->pro_id ?>')">

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
                    <?= $product->pro_name ?>
                </h2>
                <p>
                    ยอดผู้เข้าชม : <?= $product->pro_view ?>
                </p>
                <a href="product.php">
                    <i class="fa fa-arrow-left"></i>
                    <span>เมนูสินค้า</span>
                </a>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <img class="img-fluid" src="app/images/products/<?= $product->pro_img ?>">
                </div>

                <div class="col-12">
                    <hr>
                    <h3>รายละเอียด</h3>
                    <?= $product->pro_detail ?>
                </div>

                <hr>

                <div class="col-12">
                    <hr>
                    <strong>ราคา/ชิ้น : <?= number_format($product->pro_price, 2) ?> บาท (มีสินค้าทั้งหมด : <?= $product->pro_qty ?> ชิ้น)</strong> <br><br>
                    <?php if ($product->pro_qty == 0) : ?>
                        <button class="btn btn-danger" disabled>
                            สินค้าหมด
                        </button>
                    <?php else : ?>
                        <button class="btn btn-primary" onclick="addCart('<?= $product->pro_id ?>')">
                            ซื้อสินค้า
                        </button>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="app/functions/cart.js"></script>
</body>

</html>