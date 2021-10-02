<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    if (empty($_POST['re_bank']) || empty($_POST['re_acc_number']) || empty($_POST['re_acc_name'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาเลือกธนาคารเพื่อโอนเงิน"]);
        exit;
    } else if (empty($_POST['transfer_bank'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาเลือกธนาคาร"]);
        exit;
    } else if (empty($_POST['transfer_acc_number'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกเลขบัญชี"]);
        exit;
    } else if (empty($_POST['transfer_acc_name'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกชื่อบัญชี"]);
        exit;
    } else if (empty($_POST['transfer_datetime'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาระบุเวลาโอนตามสลิป"]);
        exit;
    } else if (empty($_FILES['slip']['name'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาอัพโหลดสลิปโอนเงิน"]);
        exit;
    }


    $file_extention = strrchr($_FILES['slip']['name'], '.');

    if ($file_extention == '.jpg' || $file_extention == '.jpeg' || $file_extention == '.png' || $file_extention == '.pdf') {
        $tst_id = "TST" . date("Ymd") . "-" . rand(1, 10) . rand(11, 100);
        $file_name = $_POST['od_id'] . $file_extention;
        $upload_dir = "../../images/slips/$file_name";
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไฟล์สลิปไม่ถูกต้อง กรุณาอัพโหลดใหม่"]);
        exit;
    }

    $sql = "INSERT INTO transactions (tst_id,tst_cus_username,tst_od_id,tst_amount,tst_slip,tst_re_bank,
    tst_re_acc_number,tst_re_acc_name,tst_transfer_bank,tst_transfer_acc_number,tst_transfer_acc_name,tst_transfer_datetime) VALUES
    (:tid,:cus,:oid,:amount,:slip,:rb,:raccnum,:raccname,:tb,:taccnum,:taccname,:tdt)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        "tid" => $tst_id,
        "cus" => $_SESSION['CUSTOMER_USERNAME'],
        "oid" => $_POST['od_id'],
        "amount" => $_POST['amount'],
        "slip" => $file_name,
        "rb" => $_POST['re_bank'],
        "raccnum" => $_POST['re_acc_number'],
        "raccname" => $_POST['re_acc_name'],
        "tb" => $_POST['transfer_bank'],
        "taccnum" => $_POST['transfer_acc_number'],
        "taccname" => $_POST['transfer_acc_name'],
        "tdt" => $_POST['transfer_datetime']
    ]);

    if ($result) {

        $sql = "UPDATE orders SET od_status=:status WHERE od_id=:id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'status' => "กำลังตรวจสอบหลักฐานการโอนเงิน",
            'id' => $_POST['od_id']
        ]);

        if ($result) {
            move_uploaded_file($_FILES['slip']['tmp_name'],$upload_dir);
            http_response_code(200);
            echo json_encode(['message' => "ชำระเงินสำเร็จ"]);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ชำระเงินไม่สำเร็จ"]);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ทำธุรกรรมชำระเงินไม่สำเร็จ"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
