<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once("../connect.php");

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "SELECT * FROM orders WHERE od_id = ?";
        $stmt = $pdo->prepare($sql);
        $result1 = $stmt->execute([$_GET['id']]);
        $row1 = $stmt->fetchObject();

        $sql = "SELECT * FROM order_details,products WHERE order_details.odd_pro_id=products.pro_id AND odd_od_id = ?";
        $stmt = $pdo->prepare($sql);
        $result2 = $stmt->execute([$_GET['id']]);
        $row2 = $stmt->fetchAll();

        $sql = "SELECT * FROM using_dc WHERE use_od_id = ?";
        $stmt = $pdo->prepare($sql);
        $result3 = $stmt->execute([$_GET['id']]);
        $row3 = $stmt->fetchObject();

        if ($result1 && $result2) {

            if (!empty($row1) && !empty($row2)) {
                http_response_code(200);
                echo json_encode(['message' => "โหลดข้อมูล $_GET[id] สำเร็จ", 'order' => $row1, 'detail' => $row2,'dc' => $row3]);
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ไม่มีข้อมูล $_GET[id]"]);
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "Query ไม่ผ่าน"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ถูกส่งมา"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
