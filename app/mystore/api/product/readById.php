<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "SELECT * FROM products WHERE pro_id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_GET['id']]);

        if ($result) {

            $row = $stmt->fetchObject();

            if (!empty($row)) {

                $sql = "SELECT * FROM product_types";
                $stmt = $pdo->query($sql);
                $types = $stmt->fetchAll();

                $sql = "SELECT * FROM brands";
                $stmt = $pdo->query($sql);
                $brands = $stmt->fetchAll();

                http_response_code(200);
                echo json_encode(['message' => "โหลดข้อมูล $_GET[id] สำเร็จ", 'data' => $row, 'types' => $types, 'brands' => $brands]);
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
