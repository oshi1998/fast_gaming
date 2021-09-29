<?php


session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');

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
                        <a class="nav-link" id="v-pills-discount-tab" data-toggle="pill" href="#v-pills-discount" role="tab" aria-controls="v-pills-discount" aria-selected="false">โค้ดส่วนลด (0)</a>
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
                                    <a class="nav-link" id="pills-waitpay-tab" data-toggle="pill" href="#pills-waitpay" role="tab" aria-controls="pills-waitpay" aria-selected="false">รอชำระ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitdelivery-tab" data-toggle="pill" href="#pills-waitdelivery" role="tab" aria-controls="pills-waitdelivery" aria-selected="false">รอจัดส่ง</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-waitreceive-tab" data-toggle="pill" href="#pills-waitreceive" role="tab" aria-controls="pills-waitreceive" aria-selected="false">รอรับของ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-success-tab" data-toggle="pill" href="#pills-success" role="tab" aria-controls="pills-success" aria-selected="false">สำเร็จ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-cancel-tab" data-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false">ยกเลิก</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <strong>ID: </strong>
                                            <strong>สถานะ: </strong>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-waitpay" role="tabpanel" aria-labelledby="pills-waitpay-tab">...</div>
                                <div class="tab-pane fade" id="pills-waitdelivery" role="tabpanel" aria-labelledby="pills-waitdelivery-tab">...</div>
                                <div class="tab-pane fade" id="pills-waitreceive" role="tabpanel" aria-labelledby="pills-waitreceive-tab">...</div>
                                <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">...</div>
                                <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">...</div>
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
                                    <a class="nav-link active" id="pills-unused-tab" data-toggle="pill" href="#pills-unused" role="tab" aria-controls="pills-unused" aria-selected="true">ยังไม่ได้ใช้ (0)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-used-tab" data-toggle="pill" href="#pills-used" role="tab" aria-controls="pills-used" aria-selected="false">ใช้แล้ว (0)</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-unused" role="tabpanel" aria-labelledby="pills-unused-tab">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <strong>ID: </strong>
                                            <strong>ประเภท: </strong>
                                        </div>
                                        <div class="card-body">
                                            <strong>มูลค่า: บาท</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-used" role="tabpanel" aria-labelledby="pills-used-tab">...</div>
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