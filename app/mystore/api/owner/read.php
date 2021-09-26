<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT * FROM users WHERE usr_level='เจ้าของร้าน'";
    $result = $pdo->query($sql);

    if ($result) {

        $row = $result->fetchAll();

        http_response_code(200);
        echo json_encode(['message' => "โหลดข้อมูลเจ้าของร้านสำเร็จ", 'data' => $row]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "โหลดข้อมูลเจ้าของร้านไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
