<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type:application/json");
    require_once("../connect.php");

    session_start();

    if (isset($_POST['payment_method']) && !empty($_POST['payment_method'])) {

        $_SESSION['CART_PAYMENT_METHOD'] = $_POST['payment_method'];

        http_response_code(200);
        echo json_encode(['message' => "เปลี่ยนช่องทางการชำระเงินสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี PAYMENT METHOD ถูกส่งมา"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
