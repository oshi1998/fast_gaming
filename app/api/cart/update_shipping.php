<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type:application/json");
    require_once("../connect.php");

    session_start();

    if (isset($_POST['id']) && !empty($_POST['id'])) {

        $sql = "SELECT * FROM shipping WHERE shp_id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_POST['id']]);

        if ($result) {

            $row = $stmt->fetchObject();

            if (!empty($row)) {

                $_SESSION['CART_SHIPPING'] = $row->shp_cost;
                $_SESSION['CART_SHIPPING_NAME'] = $row->shp_name;
                $_SESSION['CART_SHIPPING_ID'] = $row->shp_id;

                $_SESSION['CART_NET'] = floatval($_SESSION['CART_TOTAL'])+floatval($_SESSION['CART_SHIPPING']);

                http_response_code(200);
                echo json_encode(['message' => "อัพเดตตะกร้าสินค้าสำเร็จ"]);
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ไม่มีค่าส่ง"]);
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ค้นหาค่าส่งไม่สำเร็จ"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ถูกส่งมา"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
