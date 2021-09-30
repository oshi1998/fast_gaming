<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    header("Content-type:application/json");
    require_once("../connect.php");

    $sql = "UPDATE products SET pro_view=pro_view+1 WHERE pro_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['pro_id']]);

    http_response_code(200);
    echo json_encode(['message'=>"อัพเดตยอดวิว $_GET[pro_id] สำเร็จ"]);
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
