<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type:application/json");
    require_once("../connect.php");

    session_start();

    if (isset($_SESSION['MYCART'][$_POST['pro_id']])) {
        $_SESSION['MYCART'][$_POST['pro_id']]['PRO_AMOUNT'] = $_POST['amount'];
        $_SESSION['MYCART'][$_POST['pro_id']]['PRO_TOTAL'] = $_SESSION['MYCART'][$_POST['pro_id']]['PRO_PRICE']*$_POST['amount'];

        $cart_total = 0;
        foreach ($_SESSION['MYCART'] as $keys => $cart) {
            $cart_total += $cart['PRO_TOTAL'];
        }

        $_SESSION['CART_TOTAL'] = $cart_total;

        http_response_code(200);
        echo json_encode(['message' => "อัพเดตตะกร้าสินค้าสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่พบข้อมูลสินค้าในตะกร้า"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
