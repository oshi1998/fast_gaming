<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

if (isset($_SESSION['CUSTOMER_USERNAME']) && !empty($_SESSION['CUSTOMER_USERNAME'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $id = $_GET['id'];
        $cus = $_SESSION['CUSTOMER_USERNAME'];


        // Select ข้อมูล Orders

        $sql = "SELECT * FROM orders WHERE od_id = ? AND od_cus_username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $cus]);
        $od = $stmt->fetchObject();

        // Select ข้อมูล Order Details

        $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $odd = $stmt->fetchAll();

        // Select ข้อมูลธนาคาร
        $sql = "SELECT * FROM banks";
        $stmt = $pdo->query($sql);
        $banks = $stmt->fetchAll();
    } else {
        header("location:myaccount.php");
    }
} else {
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

    <title><?= $od->od_id ?> | <?= $store->st_name ?></title>

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
                    รหัสสั่งซื้อ : <?= $od->od_id ?>
                </h2>
                <h3>สถานะ : <?= $od->od_status ?></p>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="myaccount.php">
                        <i class="fa fa-arrow-left"></i>
                        <span>ย้อนกลับ</span>
                    </a>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>สินค้า</th>
                                    <th>ราคา/ชิ้น</th>
                                    <th>จำนวน</th>
                                    <th>ราคารวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($odd as $item) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item['pro_name'] ?></td>
                                        <td><?= $item['pro_price'] ?></td>
                                        <td><?= $item['odd_amount'] ?></td>
                                        <td><?= number_format($item['pro_price'] * $item['odd_amount'], 2) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>รวมค่าสินค้า</th>
                                    <th><?= number_format($od->od_pro_total, 2) ?></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>ค่าส่ง</th>
                                    <th><?= number_format($od->od_shipping_cost, 2) ?></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>ส่วนลด</th>
                                    <th><?= number_format($od->od_discount_cost, 2) ?></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>รวมทั้งสิ้น</th>
                                    <th><?= number_format($od->od_total, 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <?php if ($od->od_status == "รอชำระเงิน") :  ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>แบบฟอร์มชำระเงิน</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>โอนเข้าบัญชี</label>
                                    <select class="form-control">
                                        <option value="" selected disabled>---- เลือกบัญชีธนาคาร ----</option>
                                        <?php foreach ($banks as $bank) { ?>
                                            <option value="<?= $bank['bank_id'] ?>"><?= $bank['bank_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ธนาคารผู้รับโอน</label>
                                    <input type="text" class="form-control" name="re_bank" id="re_bank" readonly>
                                </div>
                                <div class="form-group">
                                    <label>เลขบัญชีผู้รับโอน</label>
                                    <input type="text" class="form-control" name="re_acc_number" id="re_acc_number" readonly>
                                </div>
                                <div class="form-group">
                                    <label>ชื่อบัญชีผู้รับโอน</label>
                                    <input type="text" class="form-control" name="re_acc_name" id="re_acc_name" readonly>
                                </div>
                                <div class="form-group">
                                    <label>ธนาคารผู้โอน</label>
                                    <input type="text" class="form-control" name="transfer_bank">
                                </div>
                                <div class="form-group">
                                    <label>เลขบัญชีผู้โอน</label>
                                    <input type="text" class="form-control" name="transfer_acc_number">
                                </div>
                                <div class="form-group">
                                    <label>ชื่อบัญชีผู้โอน</label>
                                    <input type="text" class="form-control" name="transfer_acc_name">
                                </div>
                                <div class="form-group">
                                    <label>ยอดชำระ</label>
                                    <input type="number" class="form-control" name="amount" value="<?= $od->od_total ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>เวลาที่ทำการโอน (ตามสลิป)</label>
                                    <input type="datetime-local" class="form-control" name="transfer_datetime">
                                </div>
                                <div class="form-group">
                                    <label>อัพโหลดสลิป (*จำเป็น)</label>
                                    <input type="file" class="form-control" name="slip" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>


</body>

</html>