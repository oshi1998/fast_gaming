<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty($_POST['customer'])) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องเลือกลูกค้า"]);
        exit;
    }

    $sql = "INSERT INTO using_dc (use_cus_username,use_dc_code) VALUES (:cus,:code)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'cus' => $_POST['customer'],
        'code' => $_POST['code']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "ส่งโค้ด $_POST[code] ให้ $_POST[customer] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ส่งโค้ด $_POST[code] ให้ $_POST[customer] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
