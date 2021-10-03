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
                <h4>วันที่: <?= date("d-m-Y") ?></h4>
            </div>

            <div class="col-12 mt-5">
                <?php if ($_GET['report'] == "allempnow") : ?>
                    <table class="table table-borderless text-center">
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
                            <?php $no=1; ?>
                            <?php foreach($data as $row){?>
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
                <?php else : ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>