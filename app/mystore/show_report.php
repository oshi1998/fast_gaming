<?php

require_once("permission/access.php");
require_once("permission/onlyowner.php");
require_once("api/mystore.php");

if (isset($_GET['report']) && !empty($_GET['report'])) {

    require_once("api/connect.php");

    if ($_GET['report'] == "allempnow") {
        $sql = "SELECT * FROM employees WHERE emp_status!='พ้นสภาพพนักงาน'";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อพนักงานปัจจุบัน (ทั้งหมด)";
    } else if ($_GET['report'] == "allempout") {
        $sql = "SELECT * FROM employees WHERE emp_status='พ้นสภาพพนักงาน' ORDER BY emp_out_date DESC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อพนักงานที่พ้นสภาพ (ทั้งหมด)";
    } else if ($_GET['report'] == "allcus") {
        $sql = "SELECT * FROM customers";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อลูกค้า (ทั้งหมด)";
    } else if ($_GET['report'] == "allproducts") {
        $sql = "SELECT * FROM products,product_types,brands WHERE products.pro_type=product_types.pt_id AND products.pro_brand=brands.brand_id ORDER BY pro_type ASC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายการสินค้า (ทั้งหมด)";
    } else if ($_GET['report'] == "saletoday") {
        $sql = "SELECT * FROM orders WHERE DATE(od_created) >= DATE(NOW()) - INTERVAL 1 DAY";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "ยอดขายวันนี้";
    } else if ($_GET['report'] == "sale7day") {
        $sql = "SELECT * FROM orders WHERE DATE(od_created) >= DATE(NOW()) - INTERVAL 7 DAY";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "ยอดขาย 7 วันหลังสุด";
    } else if ($_GET['report'] == "sale30day") {
        $sql = "SELECT * FROM orders WHERE DATE(od_created) >= DATE(NOW()) - INTERVAL 30 DAY";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "ยอดขาย 30 วันหลังสุด";
    } else if ($_GET['report'] == "salerange" && isset($_GET['start']) && isset($_GET['end'])) {
        $sql = "SELECT * FROM orders WHERE DATE(od_created) BETWEEN :start AND :end";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'start' => $_GET['start'],
            'end' => $_GET['end']
        ]);
        $data = $stmt->fetchAll();


        $start = date_create($_GET['start']);
        $start = date_format($start, "d-m-Y");

        $end = date_create($_GET['end']);
        $end = date_format($end, "d-m-Y");

        $title = "ยอดขายวันที่ $start ถึง $end";
    }
} else {
    header("location:show_report.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body onload="window.print()">

    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex justify-content-center">
                <h3><?= $store->st_name ?></h3>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                <img class="img-lg " src="../images/<?= $store->st_logo ?>">
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                <h3><?= $title ?></h3>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                <h4>วันที่พิมพ์: <?= date("d-m-Y") ?></h4>
            </div>

            <div class="col-12 mt-5">
                <?php if ($_GET['report'] == "allempnow") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสพนักงาน</th>
                                <th>ชื่อจริง</th>
                                <th>นามสกุล</th>
                                <th>ติดต่อ</th>
                                <th>ตำแหน่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['emp_id'] ?></td>
                                    <td><?= $row['emp_firstname'] ?></td>
                                    <td><?= $row['emp_lastname'] ?></td>
                                    <td><?= $row['emp_contact'] ?></td>
                                    <td><?= $row['emp_level'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report']=="allempout") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสพนักงาน</th>
                                <th>ชื่อจริง</th>
                                <th>นามสกุล</th>
                                <th>สาเหตุ</th>
                                <th>หมายเหตุ</th>
                                <th>วันที่พ้นสภาพ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['emp_id'] ?></td>
                                    <td><?= $row['emp_firstname'] ?></td>
                                    <td><?= $row['emp_lastname'] ?></td>
                                    <td><?= $row['emp_out_reason'] ?></td>
                                    <td><?= $row['emp_note'] ?></td>
                                    <td><?= $row['emp_out_date'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "allcus") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่่อผู้ใช้งาน</th>
                                <th>ชื่อจริง</th>
                                <th>นามสกุล</th>
                                <th>เบอร์โทร</th>
                                <th>ที่อยู่</th>
                                <th>อีเมล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['cus_username'] ?></td>
                                    <td><?= $row['cus_firstname'] ?></td>
                                    <td><?= $row['cus_lastname'] ?></td>
                                    <td><?= $row['cus_phone'] ?></td>
                                    <td><?= $row['cus_address'] ?></td>
                                    <td><?= $row['cus_email'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "allproducts") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>ประเภท</th>
                                <th>ยี่ห้อ</th>
                                <th>ชื่อ</th>
                                <th>จำนวน</th>
                                <th>ราคา/ชื้น</th>
                                <th>รวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_qty = 0;
                            $net = 0;
                            ?>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $total_qty += $row['pro_qty'];
                                $net += $row['pro_qty'] * $row['pro_price'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['pro_id'] ?></td>
                                    <td><?= $row['pt_name'] ?></td>
                                    <td><?= $row['brand_name'] ?></td>
                                    <td><?= $row['pro_name'] ?></td>
                                    <td><?= $row['pro_qty'] ?></td>
                                    <td><?= $row['pro_price'] ?></td>
                                    <td><?= number_format($row['pro_qty'] * $row['pro_price'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>รวมทั้งสิ้น</th>
                                <th><?= $total_qty; ?></th>
                                <td></td>
                                <th><?= number_format($net, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php elseif ($_GET['report'] == "saletoday") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>รายการสินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคาทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $net = 0;
                            ?>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id=?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$row['od_id']]);
                                $details = $stmt->fetchAll();

                                $net += $row['od_total'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['od_id'] ?></td>
                                    <td>
                                        <ul>
                                            <?php $amount = 0; ?>
                                            <?php foreach ($details as $detail) { ?>
                                                <li><?= $detail['pro_name'] . " (จำนวน: $detail[odd_amount])" ?></li>
                                                <?php $amount += $detail['odd_amount']; ?>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?= $amount; ?></td>
                                    <td><?= number_format($row['od_total'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>รวมทั้งสิ้น</th>
                                <th><?= number_format($net, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php elseif ($_GET['report'] == "sale7day") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>รายการสินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคาทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $net = 0;
                            ?>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id=?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$row['od_id']]);
                                $details = $stmt->fetchAll();

                                $net += $row['od_total'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['od_id'] ?></td>
                                    <td>
                                        <ul>
                                            <?php $amount = 0; ?>
                                            <?php foreach ($details as $detail) { ?>
                                                <li><?= $detail['pro_name'] . " (จำนวน: $detail[odd_amount])" ?></li>
                                                <?php $amount += $detail['odd_amount']; ?>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?= $amount; ?></td>
                                    <td><?= number_format($row['od_total'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>รวมทั้งสิ้น</th>
                                <th><?= number_format($net, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php elseif ($_GET['report'] == "sale30day") : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>รายการสินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคาทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $net = 0;
                            ?>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id=?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$row['od_id']]);
                                $details = $stmt->fetchAll();

                                $net += $row['od_total'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['od_id'] ?></td>
                                    <td>
                                        <ul>
                                            <?php $amount = 0; ?>
                                            <?php foreach ($details as $detail) { ?>
                                                <li><?= $detail['pro_name'] . " (จำนวน: $detail[odd_amount])" ?></li>
                                                <?php $amount += $detail['odd_amount']; ?>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?= $amount; ?></td>
                                    <td><?= number_format($row['od_total'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>รวมทั้งสิ้น</th>
                                <th><?= number_format($net, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php elseif ($_GET['report'] == "salerange" && isset($_GET['start']) && isset($_GET['end'])) : ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>รายการสินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคาทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $net = 0;
                            ?>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id=?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$row['od_id']]);
                                $details = $stmt->fetchAll();

                                $net += $row['od_total'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['od_id'] ?></td>
                                    <td>
                                        <ul>
                                            <?php $amount = 0; ?>
                                            <?php foreach ($details as $detail) { ?>
                                                <li><?= $detail['pro_name'] . " (จำนวน: $detail[odd_amount])" ?></li>
                                                <?php $amount += $detail['odd_amount']; ?>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?= $amount; ?></td>
                                    <td><?= number_format($row['od_total'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>รวมทั้งสิ้น</th>
                                <th><?= number_format($net, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>