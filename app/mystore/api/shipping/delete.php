<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "DELETE FROM shipping WHERE shp_id=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_GET['id']]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => "ลบข้อมูล $_GET[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ลบข้อมูล $_GET[id] ไม่สำเร็จ"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ส่งมา"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
