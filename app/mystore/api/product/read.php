<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT * FROM products,product_types,brands WHERE products.pro_type=product_types.pt_id AND products.pro_brand=brands.brand_id";
    $result = $pdo->query($sql);

    if ($result) {
        $row = $result->fetchAll();
        http_response_code(200);
        echo json_encode(['message' => "โหลดข้อมูลสินค้าสำเร็จ", 'data' => $row]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "โหลดข้อมูลสินค้าไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
