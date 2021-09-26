<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['description']))) {
        http_response_code(412);
        echo json_encode(['message' => "คำอธิบายเว็บไซต์ห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['keywords']))) {
        http_response_code(412);
        echo json_encode(['message' => "คำค้นหา Keywords ห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['author']))) {
        http_response_code(412);
        echo json_encode(['message' => "ผู้เขียน ห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "UPDATE store SET st_description=:desc,st_keywords=:key,st_author=:author";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'desc' => $_POST['description'],
        'key' => $_POST['keywords'],
        'author' => $_POST['author'],
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "บันทึกข้อมูล SEO Meta Tags สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "บันทึกข้อมูล SEO Meta Tags ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
