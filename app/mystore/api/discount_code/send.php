<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty($_POST['customer'])) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องเลือกลูกค้า"]);
        exit;
    }

    if ($_POST['customer'] == "*") {
        $sql = "SELECT * FROM customers";
        $stmt = $pdo->query($sql);
        $customers = $stmt->fetchAll();

        if (!empty($customers)) {

            $num_query = 0;

            foreach ($customers as $cus) {
                $sql = "INSERT INTO using_dc (use_cus_username,use_dc_code) VALUES (:cus,:code)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'cus' => $cus['cus_username'],
                    'code' => $_POST['code']
                ]);

                if ($result) {
                    $num_query++;
                }
            }

            if ($num_query == count($customers)) {
                http_response_code(200);
                echo json_encode(['message' => "ส่งโค้ด $_POST[code] ให้ลูกค้าทั้งหมดสำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ส่งโค้ด $_POST[code] ให้ลูกค้าทั้งหมดไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ส่งโค้ด $_POST[code] ให้ลูกค้าทั้งหมดได้ เพราะ ไม่มีรายชื่อลูกค้า"]);
            exit;
        }
    } else {
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
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
