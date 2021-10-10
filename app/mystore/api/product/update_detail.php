<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['id']))) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มีรหัสสินค้าส่งมา"]);
        exit;
    }

    $sql = "UPDATE products SET pro_detail=:detail WHERE pro_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'detail' => $_POST['detail'],
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
