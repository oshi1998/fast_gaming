<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

//unset($_SESSION['MYCART']);
if (!isset($_SESSION['CUSTOMER_USERNAME']) && empty($_SESSION['CUSTOMER_USERNAME'])) {
    header("location:login.php");
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

    <title>ตะกร้าสินค้า | <?= $store->st_name ?></title>

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
            <?php if (isset($_SESSION['MYCART']) && !empty($_SESSION['MYCART'])) : ?>
                <div class="heading_container heading_center">
                    <h2>
                        ตะกร้าสินค้า
                    </h2>
                </div>
                <div class="row">
                    <?php if (count($_SESSION['MYCART']) > 0) : ?>
                        <?php $no = 1; ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>สินค้า</th>
                                        <th>ราคาต่อชิ้น</th>
                                        <th>จำนวน</th>
                                        <th>ราคารวม</th>
                                        <th>ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_SESSION['MYCART'] as $id => $cart) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $cart['PRO_NAME'] ?></td>
                                            <td><?= $cart['PRO_PRICE'] ?></td>
                                            <td><?= $cart['PRO_AMOUNT'] ?></td>
                                            <td><?= number_format($cart['PRO_TOTAL'],2) ?></td>
                                            <td>
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                    <span>ลบ</span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th>รวมทั้งหมด</th>
                                        <th><?= number_format($_SESSION['CART_TOTAL'],2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
            <?php else : ?>
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">ตะกร้าสินค้าว่าง</h1>
                        <p class="lead">เลือกสินค้ากันเลย <a href="product.php">คลิก!</a></p>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>


</body>

</html>