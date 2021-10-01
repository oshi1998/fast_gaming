<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header("Content-type:application/json");
    session_start();

    if (isset($_SESSION['CART_PAYMENT_METHOD']) && !empty($_SESSION['CART_PAYMENT_METHOD'])) {
        http_response_code(200);
        echo json_encode(['message' => "ช่องทางการชำระเงินตอนนี้", 'payment_method' => $_SESSION['CART_PAYMENT_METHOD']]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มีข้อมูลช่องทางการชำระเงิน"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
