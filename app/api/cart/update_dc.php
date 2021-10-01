<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if (isset($_POST['code']) && !empty($_POST['code'])) {


        if (!isset($_SESSION['CART_DISCOUNT_CODE']) && empty($_SESSION['CART_DISCOUNT_CODE'])) {

            $sql = "SELECT * FROM discount_codes WHERE dc_code=?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_POST['code']]);

            if ($result) {
                $row = $stmt->fetchObject();

                if (!empty($row)) {

                    $_SESSION['CART_DISCOUNT'] = $row->dc_value;
                    $_SESSION['CART_DISCOUNT_CODE'] = $row->dc_code;

                    if ($row->dc_type == "ส่วนลดเงินสด") {
                        $_SESSION['CART_NET'] -= floatval($_SESSION['CART_DISCOUNT']);
                    } else {
                        $_SESSION['CART_NET'] -= floatval($_SESSION['CART_NET']) * floatval($_SESSION['CART_DISCOUNT'] / 100);
                    }

                    http_response_code(200);
                    echo json_encode(['message' => "ใช้โค้ดส่วนลดสำเร็จ"]);
                } else {
                    http_response_code(412);
                    echo json_encode(['message' => "ค้นหาโค้ดไม่สำเร็จ"]);
                    exit;
                }
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ค้นหาโค้ดไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "คุณใช้โค้ดส่วนลดไปแล้ว หากต้องการเปลี่ยนกรุณายกเลิกอันเดิมก่อน"]);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี CODE ส่งมา"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
