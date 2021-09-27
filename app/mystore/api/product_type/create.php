<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อประเภทห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "INSERT INTO product_types (pt_name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลประเภทสินค้าสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลประเภทสินค้าไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
