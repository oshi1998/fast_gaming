<?php


session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (!isset($_SESSION['CUSTOMER_USERNAME']) && empty($_SESSION['CUSTOMER_USERNAME'])) {
    header("location:login.php");
} else {

    //รับค่า Username
    $cus = $_SESSION['CUSTOMER_USERNAME'];

    // รายการซื้อทั้งหมด
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus]);
    $od1 = $stmt->fetchAll();

    // รายการซื้อ สถานะ รอชำระเงิน/กำลังตรวจสอบหลักฐานการโอนเงิน
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? AND od_status = ? OR od_status = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus, "รอชำระเงิน", "กำลังตรวจสอบหลักฐานการโอนเงิน"]);
    $od2 = $stmt->fetchAll();

    // รายการซื้อ สถานะ เตรียมจัดส่งสินค้า
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? AND od_status = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus, "เตรียมจัดส่งสินค้า"]);
    $od3 = $stmt->fetchAll();

    // รายการซื้อ สถานะ จัดส่งสินค้าเรียบร้อย
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? AND od_status = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus, "จัดส่งสินค้าเรียบร้อย"]);
    $od4 = $stmt->fetchAll();

    // รายการซื้อ สถานะ สำเร็จ
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? AND od_status = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus, "สำเร็จ"]);
    $od5 = $stmt->fetchAll();

    // รายการซื้อ สถานะ ยกเลิกแล้ว
    $sql = "SELECT * FROM orders WHERE od_cus_username = ? AND od_status = ? ORDER BY od_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus, "ยกเลิกแล้ว"]);
    $od6 = $stmt->fetchAll();

    // โค้ดส่วนลดที่ยังไม่ได้ใช้
    $sql = "SELECT * FROM using_dc,discount_codes WHERE using_dc.use_dc_code=discount_codes.dc_code AND use_od_id is null AND use_cus_username=? ORDER BY use_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus]);
    $dc1 = $stmt->fetchAll();

    // โค้ดส่วนลดที่ใช้แล้ว
    $sql = "SELECT * FROM using_dc,discount_codes WHERE using_dc.use_dc_code=discount_codes.dc_code AND use_od_id is not null AND use_cus_username=? ORDER BY use_created DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cus]);
    $dc2 = $stmt->fetchAll();
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

    <title>บัญชีของฉัน | <?= $store->st_name ?></title>

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
            <div class="heading_container heading_center mb-5">
                <h2>
                    บัญชีของฉัน
                </h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">ข้อมูลส่วนตัว</a>
                        <a class="nav-link" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab" aria-controls="v-pills-order" aria-selected="false">รายการซื้อของฉัน</a>
                        <a class="nav-link" id="v-pills-transaction-tab" data-toggle="pill" href="#v-pills-transaction" role="tab" aria-controls="v-pills-transaction" aria-selected="false">บันทึกธุรกรรม</a>
                        <a class="nav-link" id="v-pills-discount-tab" data-toggle="pill" href="#v-pills-discount" role="tab" aria-controls="v-pills-discount" aria-selected="false">โค้ดส่วนลด (<?= count($dc1) ?>)</a>
                    </div>

                </div>
                <div class="col-lg-8 col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                            <form id="profileForm">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ชื่อผู้ใช้งาน</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control-plaintext" id="username" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ชื่อจริง</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="firstname" id="firstname">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">นามสกุล</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="lastname" id="lastname">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">อีเมล</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" id="email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">เพศ</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="ชาย">ชาย</option>
                                            <option value="หญิง">หญิง</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary float-right" onclick="updateProfile()">บันทึกการเปลี่ยนแปลง</button>
                            </form>

                            <br><br>

                            <form id="addressForm">
                                <h3>ข้อมูลสำหรับจัดส่ง</h3>

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


                                <button type="button" class="btn btn-primary float-right" onclick="updateAddress()">บันทึกการเปลี่ยนแปลง</button>
                            </form>

                            <br><br>

                            <form id="passwordForm">
                                <h3>เปลี่ยนรหัสผ่าน</h3>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">รหัสผ่านเดิม</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="old_password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">รหัสผ่านใหม่</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="new_password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ยืนยันรหัสผ่านใหม่</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="confirm_new_password">
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary float-right" onclick="updatePassword()">บันทึกการเปลี่ยนแปลง</button>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">ทั้งหมด</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitpay-tab" data-toggle="pill" href="#pills-waitpay" role="tab" aria-controls="pills-waitpay" aria-selected="false">รอชำระ (<?= count($od2) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitdelivery-tab" data-toggle="pill" href="#pills-waitdelivery" role="tab" aria-controls="pills-waitdelivery" aria-selected="false">รอจัดส่ง (<?= count($od3) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitreceive-tab" data-toggle="pill" href="#pills-waitreceive" role="tab" aria-controls="pills-waitreceive" aria-selected="false">รอรับของ (<?= count($od4) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-success-tab" data-toggle="pill" href="#pills-success" role="tab" aria-controls="pills-success" aria-selected="false">สำเร็จ (<?= count($od5) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-cancel-tab" data-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false">ยกเลิก (<?= count($od6) ?>)</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                                    <?php if (count($od1) > 0) : ?>
                                        <?php foreach ($od1 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ยังไม่มีรายการสั่งซื้อ!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitpay" role="tabpanel" aria-labelledby="pills-waitpay-tab">
                                    <?php if (count($od2) > 0) : ?>
                                        <?php foreach ($od2 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between">
                                                    <?php if ($od['od_status'] == "รอชำระเงิน") : ?>
                                                        <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-success float-right">ชำระเงิน</a>
                                                    <?php endif ?>
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ไม่มีข้อมูล!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitdelivery" role="tabpanel" aria-labelledby="pills-waitdelivery-tab">
                                    <?php if (count($od3) > 0) : ?>
                                        <?php foreach ($od3 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ไม่มีข้อมูล!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-waitreceive" role="tabpanel" aria-labelledby="pills-waitreceive-tab">
                                    <?php if (count($od4) > 0) : ?>
                                        <?php foreach ($od4 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                    <hr>
                                                    <strong>ส่งสินค้าเมื่อ: </strong> <?= $od['od_delivery_date'] ?> <br>
                                                    <strong>EMS: </strong> <?= $od['od_ems'] ?>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ไม่มีข้อมูล!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                    <?php if (count($od5) > 0) : ?>
                                        <?php foreach ($od5 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ไม่มีข้อมูล!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
                                    <?php if (count($od6) > 0) : ?>
                                        <?php foreach ($od6 as $od) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>ID: <?= $od['od_id'] ?></strong>
                                                    <strong>สถานะ: <?= $od['od_status'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>ยอดคำสั่งซื้อทั้งหมด: <?= number_format($od['od_total'], 2) ?> บาท</strong>
                                                    <hr>
                                                    <strong style="color:red;">สาเหตุ: </strong> <?= $od['od_note'] ?>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="myorder.php?id=<?= $od['od_id'] ?>" class="btn btn-info float-right">ดูคำสั่งซื้อ</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>ไม่มีข้อมูล!</strong> <br>
                                            ลองเลือกสินค้าจากร้านเราได้ที่นี้ <a href="product.php">คลิก!</a>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel" aria-labelledby="v-pills-transaction-tab">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ประเภท</th>
                                            <th>วันที่</th>
                                            <th>รหัสรายการสั่งซื้อ</th>
                                            <th>จำนวนเงิน</th>
                                            <th>สถานะ</th>
                                            <th>หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-discount" role="tabpanel" aria-labelledby="v-pills-discount-tab">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-unused-tab" data-toggle="pill" href="#pills-unused" role="tab" aria-controls="pills-unused" aria-selected="true">ยังไม่ได้ใช้ (<?= count($dc1) ?>)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-used-tab" data-toggle="pill" href="#pills-used" role="tab" aria-controls="pills-used" aria-selected="false">ใช้แล้ว (<?= count($dc2) ?>)</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-unused" role="tabpanel" aria-labelledby="pills-unused-tab">
                                    <?php if (count($dc1) > 0) : ?>
                                        <?php foreach ($dc1 as $dc) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>CODE: <?= $dc['dc_code'] ?></strong>
                                                    <strong>ประเภท: <?= $dc['dc_type'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>มูลค่า: <?= number_format($dc['dc_value']) ?> <?= ($dc['dc_type'] == "ส่วนลดเงินสด") ? "บาท" : '%' ?></strong>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else :  ?>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong>ตอนนี้ท่านยังไม่มีโค้ดส่วนลด!</strong> <br>
                                            หากท่านได้รับสิทธิ์ใช้โค้ดส่วนลด ทางเราจะส่งให้และแจ้งให้ท่านทราบทันที
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="tab-pane fade" id="pills-used" role="tabpanel" aria-labelledby="pills-used-tab">
                                    <?php if (count($dc2) > 0) : ?>
                                        <?php foreach ($dc2 as $dc) { ?>
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between">
                                                    <strong>CODE: <?= $dc['dc_code'] ?></strong>
                                                    <strong>ประเภท: <?= $dc['dc_type'] ?></strong>
                                                </div>
                                                <div class="card-body">
                                                    <strong>มูลค่า: <?= number_format($dc['dc_value']) ?> <?= ($dc['dc_type'] == "ส่วนลดเงินสด") ? "บาท" : '%' ?></strong>
                                                    <br>
                                                    <strong>รหัสรายการสั่งซื้อ: <?= $dc['use_od_id'] ?></strong>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php else :  ?>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong>ตอนนี้ท่านยังไม่มีโค้ดส่วนลดที่ใช้แล้ว!</strong> <br>
                                            หากท่านได้รับสิทธิ์ใช้โค้ดส่วนลด ทางเราจะส่งให้และแจ้งให้ท่านทราบทันที
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="app/functions/myaccount.js"></script>
</body>

</html>