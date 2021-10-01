<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (!isset($_SESSION['CUSTOMER_USERNAME']) && empty($_SESSION['CUSTOMER_USERNAME'])) {
    header("location:login.php");
} else if (!isset($_SESSION['MYCART']) && empty($_SESSION['MYCART'])) {
    header("location:product.php");
} else {
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

    <title>ทำการสั่งซื้อ | <?= $store->st_name ?></title>

    <?php require_once('layouts/head.php'); ?>
</head>

<body class="sub_page" onload="myprofile()">

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
                    ทำการสั่งซื้อ
                </h2>
            </div>
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3>ข้อมูลที่อยู่สำหรับจัดส่ง</h3>
                        </div>
                        <div class="card-body">
                            <form id="addressForm">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ที่อยู่</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="address" id="address"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">เบอร์โทร</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="phone" id="phone">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary float-right" onclick="updateAddress()">อัพเดตข้อมูลที่อยู่</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>สรุปรายการสั่งซื้อ</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>สินค้า</th>
                                            <th>ราคาต่อชิ้น</th>
                                            <th>จำนวน</th>
                                            <th>ราคารวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($_SESSION['MYCART'] as $id => $cart) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $cart['PRO_NAME'] ?></td>
                                                <td><?= number_format($cart['PRO_PRICE'], 2) ?></td>
                                                <td><?= $cart['PRO_AMOUNT'] ?></td>
                                                <td><?= number_format($cart['PRO_TOTAL'], 2) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>ค่าสินค้าทั้งหมด</th>
                                            <th><?= number_format($_SESSION['CART_TOTAL'], 2) ?></th>
                                        </tr>
                                        <tr>
                                            <td>การจัดส่ง</td>
                                            <td>
                                                <strong><?= $_SESSION['CART_SHIPPING_NAME'] ?></strong>
                                            </td>
                                            <td></td>
                                            <th>ค่าส่ง</th>
                                            <th><?= number_format($_SESSION['CART_SHIPPING'], 2) ?></th>
                                        </tr>
                                        <tr>
                                            <td>โค้ดส่วนลด</td>
                                            <td>
                                                <strong><?= (!isset($_SESSION['CART_DISCOUNT_CODE'])) ? 'ไม่มีโค้ดส่วนลด' : $_SESSION['CART_DISCOUNT_CODE'] ?></strong>
                                            </td>
                                            <td></td>
                                            <th>ส่วนลด</th>
                                            <th><?= number_format($_SESSION['CART_DISCOUNT'], 2) ?></th>
                                        </tr>
                                        <tr>
                                            <td>วิธีการชำระเงิน</td>
                                            <td>
                                                <strong><?= $_SESSION['CART_PAYMENT_METHOD'] ?></strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>รวมทั้งสิ้น</th>
                                            <th><?= number_format($_SESSION['CART_NET'], 2) ?></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-primary" onclick="window.location='mycart.php'">กลับไปตะกร้าสินค้า</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" onclick="order()">สั่งซื้อสินค้า</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="app/functions/checkbill.js"></script>
</body>

</html>