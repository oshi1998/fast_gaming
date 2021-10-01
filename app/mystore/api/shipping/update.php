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

    $sql = "UPDATE shipping SET shp_name=:name,shp_cost=:cost WHERE shp_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'cost' => $_POST['cost'],
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
