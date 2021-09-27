<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');


    if (empty(trim($_GET['code']))) {
        http_response_code(412);
        echo json_encode(['message' => "โค้ดส่วนลดห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "SELECT dc_code FROM discount_codes WHERE dc_code=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['code']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['message' => "$_GET[code] สามารถใช้งานได้"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "$_GET[code] ถูกใช้งานแล้ว"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
