<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['code']))) {
        http_response_code(412);
        echo json_encode(['message' => "โค้ดส่วนลดห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty($_POST['type'])){
        http_response_code(412);
        echo json_encode(['message' => "ยังไม่ได้เลือกประเภทส่วนลด"]);
        exit;
    } else if (empty(trim($_POST['value']))) {
        http_response_code(412);
        echo json_encode(['message' => "มูลค่าส่วนลดห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "INSERT INTO discount_codes (dc_code,dc_type,dc_value) VALUES (:code,:type,:value)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'code' => $_POST['code'],
        'type' => $_POST['type'],
        'value' => $_POST['value']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "เพิ่มโค้ดส่วนลดสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มโค้ดส่วนลดไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
