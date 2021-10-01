<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['bank_name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อธนาคารห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['acc_number']))){
        http_response_code(412);
        echo json_encode(['message' => "เลขบัญชีห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['acc_name']))){
        http_response_code(412);
        echo json_encode(['message' => "ชื่อบัญชีห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "UPDATE banks SET bank_name=:bname,bank_acc_number=:accnum,bank_acc_name=:accname WHERE bank_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'bname' => $_POST['bank_name'],
        'accnum' => $_POST['acc_num'],
        'accname' => $_POST['acc_name'],
        'id' => $_POST['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[id] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
