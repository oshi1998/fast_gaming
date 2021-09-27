<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');


    if (empty(trim($_GET['name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อยี่ห้อห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "SELECT brand_name FROM brands WHERE brand_name=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['name']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['message' => "$_GET[username] สามารถใช้งานได้"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "$_GET[username] ถูกใช้งานแล้ว"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
