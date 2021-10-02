<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    $od_id = "OD" . date("Ymd") . "-" . rand(1, 10) . rand(10, 99);

    if ($_SESSION['CART_PAYMENT_METHOD'] == "เก็บเงินปลายทาง") {
        $status = "เตรียมจัดส่งสินค้า";
    } else {
        $status = "รอชำระเงิน";
    }

    $sql = "INSERT INTO orders (od_id,od_cus_username,od_amount,od_pro_total,od_shipping_cost,od_discount_cost,od_total,
    od_payment_method,od_delivery_type,od_status) VALUES (:id,:cus,:amount,:pro,:shipping,:discount,:total,:pm,:dt,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $od_id,
        'cus' => $_SESSION['CUSTOMER_USERNAME'],
        'amount' => count($_SESSION['MYCART']),
        'pro' => $_SESSION['CART_TOTAL'],
        'shipping' => $_SESSION['CART_SHIPPING'],
        'discount' => $_SESSION['CART_DISCOUNT'],
        'total' => $_SESSION['CART_NET'],
        'pm' => $_SESSION['CART_PAYMENT_METHOD'],
        'dt' => $_SESSION['CART_SHIPPING_NAME'],
        'status' => $status
    ]);

    if ($result) {
        if (isset($_SESSION['CART_DISCOUNT_CODE']) && !empty($_SESSION['CART_DISCOUNT_CODE'])) {

            $sql = "UPDATE using_dc SET use_od_id=:id WHERE use_dc_code=:code AND use_cus_username=:cus";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $od_id,
                'code' => $_SESSION['CART_DISCOUNT_CODE'],
                'cus' => $_SESSION['CUSTOMER_USERNAME']
            ]);
        }

        $query_odd = 0;

        foreach ($_SESSION['MYCART'] as $id => $cart) {
            $sql = "INSERT INTO order_details (odd_od_id,odd_pro_id,odd_amount) VALUES (:od_id,:pro_id,:amount)";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'od_id' => $od_id,
                'pro_id' => $id,
                'amount' => $cart['PRO_AMOUNT']
            ]);

            if ($result) {
                $query_odd++;
            }
        }

        $query_stock = 0;

        foreach ($_SESSION['MYCART'] as $id => $cart) {
            $sql = "UPDATE products SET pro_qty=pro_qty-:amount WHERE pro_id=:id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'id' => $id,
                'amount' => $cart['PRO_AMOUNT']
            ]);

            if ($result) {
                $query_stock++;
            }
        }

        if ($query_odd == count($_SESSION['MYCART']) && $query_stock == count($_SESSION['MYCART'])) {

            unset($_SESSION['MYCART']);
            unset($_SESSION['CART_TOTAL']);
            unset($_SESSION['CART_NET']);
            unset($_SESSION['CART_SHIPPING']);
            unset($_SESSION['CART_SHIPPING_NAME']);
            unset($_SESSION['CART_SHIPPING_ID']);
            unset($_SESSION['CART_DISCOUNT']);
            unset($_SESSION['CART_DISCOUNT_CODE']);
            unset($_SESSION['CART_PAYMENT_METHOD']);

            http_response_code(200);
            echo json_encode(['message' => "สั่งซื้อสินค้าสำเร็จ"]);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['message' => "สั่งซื้อไม่สำเร็จ"]);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "สั่งซื้อไม่สำเร็จ"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
