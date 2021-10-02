<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once("../connect.php");


    if (empty($_POST['id'])) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มีข้อมูลรหัสสั่งซื้อ"]);
        exit;
    } else if (empty(trim($_POST['note']))) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องระบุสาเหตุที่ยกเลิกด้วย"]);
        exit;
    }

    $sql = "UPDATE orders SET od_status=:status,od_note=:note WHERE od_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'status' => "ยกเลิกแล้ว",
        'note' => $_POST['note'],
        'id' => $_POST['id']
    ]);

    if ($result) {

        $sql = "SELECT * FROM order_details WHERE odd_od_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $odd = $stmt->fetchAll();

        $update_pro_query = 0;

        foreach ($odd as $od) {
            $sql = "UPDATE products SET pro_qty=pro_qty+:amount WHERE pro_id=:id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'amount' => $od['odd_amount'],
                'id' => $od['odd_pro_id']
            ]);

            if ($result) {
                $update_pro_query++;
            }
        }

        if ($update_pro_query == count($odd)) {
            http_response_code(200);
            echo json_encode(['message' => "ยกเลิกรหัสสั่งซื้อ $_POST[id] พร้อมคืนสินค้ากลับเข้าสต็อกเรียบร้อย"]);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ยกเลิกรหัสสั่งซื้อ $_POST[id] ไม่สำเร็จ"]);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ยกเลิกรหัสสั่งซื้อ $_POST[id] ไม่สำเร็จ"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
