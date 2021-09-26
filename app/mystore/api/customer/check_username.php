<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');


    if (empty(trim($_GET['username']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อผู้ใช้งานห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "SELECT cus_username FROM customers WHERE cus_username=?
    UNION SELECT usr_username FROM users WHERE usr_username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['username'], $_GET['username']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['message' => "ชื่อผู้ใช้งาน $_GET[username] สามารถใช้งานได้"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อผู้ใช้งาน $_GET[username] ถูกใช้งานแล้ว"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
