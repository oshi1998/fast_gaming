<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    $sql = "SELECT * FROM products WHERE pro_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $row = $stmt->fetchObject();

    if (isset($_SESSION['MYCART'][$row->pro_id])) {
        $_SESSION['MYCART'][$row->pro_id]['PRO_AMOUNT'] += 1;
        $_SESSION['MYCART'][$row->pro_id]['PRO_TOTAL'] = $_SESSION['MYCART'][$row->pro_id]['PRO_PRICE'] * $_SESSION['MYCART'][$row->pro_id]['PRO_AMOUNT'];
    } else {
        $_SESSION['MYCART'][$row->pro_id] = array(
            'PRO_NAME' => $row->pro_name,
            'PRO_PRICE' => $row->pro_price,
            'PRO_AMOUNT' => 1,
            'PRO_QTY' => $row->pro_qty,
            'PRO_TOTAL' => $row->pro_price,
        );
    }


    $cart_total = 0;

    foreach ($_SESSION['MYCART'] as $keys => $cart) {
        $cart_total += $cart['PRO_TOTAL'];
    }

    if(!isset($_SESSION['CART_SHIPPING']) && empty($_SESSION['CART_SHIPPING'])){
        $_SESSION['CART_SHIPPING'] = 0;
    }

    if(!isset($_SESSION['CART_DISCOUNT']) && empty($_SESSION['CART_DISCOUNT'])){
        $_SESSION['CART_DISCOUNT'] = 0;
    }

    if(!isset($_SESSION['CART_PAYMENT_METHOD']) && empty($_SESSION['CART_PAYMENT_METHOD'])){
        $_SESSION['CART_PAYMENT_METHOD'] = "โอน/ชำระผ่านบัญชีธนาคาร";
    }

    $_SESSION['CART_TOTAL'] = $cart_total;
    $_SESSION['CART_NET'] = $_SESSION['CART_TOTAL']+$_SESSION['CART_SHIPPING'];
    $_SESSION['CART_NET'] -= $_SESSION['CART_DISCOUNT'];

    http_response_code(200);
    echo json_encode(['message' => "เพิ่มสินค้าลงตระกร้าสำเร็จ"]);
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
