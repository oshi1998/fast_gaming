<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once("../connect.php");

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "UPDATE orders SET od_status=:status WHERE od_id=:id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'status' => "เตรียมจัดส่งสินค้า",
            'id' => $_GET['id']
        ]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => "อนุมัติการชำระเงิน $_GET[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "อนุมัติการชำระเงิน $_GET[id] ไม่สำเร็จ"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ถูกส่งมา"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
