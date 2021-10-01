<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    if (isset($_SESSION['MYCART'][$_GET['id']])) {

        unset($_SESSION['MYCART'][$_GET['id']]); //ลบสินค้า

        if (count($_SESSION['MYCART']) > 0) {
            $cart_total = 0;
            foreach ($_SESSION['MYCART'] as $keys => $cart) {
                $cart_total += $cart['PRO_TOTAL'];
            }

            if (!isset($_SESSION['CART_SHIPPING']) && empty($_SESSION['CART_SHIPPING'])) {
                $_SESSION['CART_SHIPPING'] = 0;
            }

            $_SESSION['CART_TOTAL'] = $cart_total;
            $_SESSION['CART_NET'] = $_SESSION['CART_TOTAL'] + $_SESSION['CART_SHIPPING'];
        } else {
            unset($_SESSION['MYCART']);
            unset($_SESSION['CART_TOTAL']);
            unset($_SESSION['CART_NET']);
            unset($_SESSION['CART_SHIPPING']);
            unset($_SESSION['CART_SHIPPING_NAME']);
            unset($_SESSION['CART_SHIPPING_ID']);
            unset($_SESSION['CART_DISCOUNT']);
            unset($_SESSION['CART_DISCOUNT_CODE']);
            unset($_SESSION['CART_PAYMENT_METHOD']);
        }

        http_response_code(200);
        echo json_encode(['message' => "ลบสินค้าในตระกร้าสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ลบไม่ได้ เพราะ ไม่มีสินค้าในตะกร้า"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
