<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once("../connect.php");


    if (empty($_POST['id'])) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มีข้อมูลรหัสสั่งซื้อ"]);
        exit;
    } else if (empty($_POST['date'])) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องระบุวันที่ดำเนินการจัดส่งด้วย"]);
        exit;
    }

    $sql = "UPDATE orders SET od_status=:status,od_delivery_date=:date,od_ems=:ems WHERE od_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'status' => "จัดส่งสินค้าเรียบร้อย",
        'date' => $_POST['date'],
        'ems' => $_POST['ems'],
        'id' => $_POST['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message'=>"อัพเดตสถานะจัดส่งสินค้า $_POST[id] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตสถานะจัดส่งสินค้า $_POST[id] ไม่สำเร็จ"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
