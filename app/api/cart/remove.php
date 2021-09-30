<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    if (isset($_SESSION['MYCART'][$_GET['id']])) {
        unset($_SESSION['MYCART'][$_GET['id']]);
    } else {
        http_response_code(412);
        echo json_encode(['message'=> "ลบไม่ได้ เพราะ ไม่มีสินค้าในตะกร้า"]);
        exit;
    }

    $cart_total = 0;
    foreach ($_SESSION['MYCART'] as $keys => $cart) {
        $cart_total += $cart['PRO_TOTAL'];
    }

    $_SESSION['CART_TOTAL'] = $cart_total;

    http_response_code(200);
    echo json_encode(['message' => "ลบสินค้าในตระกร้าสำเร็จ"]);
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
