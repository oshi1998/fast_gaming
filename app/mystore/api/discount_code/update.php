<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['code']))) {
        http_response_code(412);
        echo json_encode(['message' => "โค้ดส่วนลดห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['value']))) {
        http_response_code(412);
        echo json_encode(['message' => "มูลค่าส่วนลดห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "UPDATE discount_codes SET dc_code=:code,dc_type=:type,dc_value=:value WHERE dc_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'code' => $_POST['code'],
        'type' => $_POST['type'],
        'value' => $_POST['value'],
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
