<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');


    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "UPDATE products SET pro_status=:status WHERE pro_id=:id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'status' => 0,
            'id' => $_GET["id"]
        ]);

        if ($result) {

            http_response_code(200);
            echo json_encode(['message' => "เปลี่ยนสถานะ $_GET[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "เปลี่ยนสถานะ $_GET[id] ไม่สำเร็จ"]);
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
