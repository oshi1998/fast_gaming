<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อประเภทการจัดส่งห้ามเป็นค่าว่าง"]);
        exit;
    }else if(empty(trim($_POST['cost']))){
        http_response_code(412);
        echo json_encode(['message' => "ค่าจัดส่งห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "INSERT INTO shipping (shp_name,shp_cost) VALUES (:name,:cost)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'cost' => $_POST['cost']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลการจัดส่งสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลการจัดส่งไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
