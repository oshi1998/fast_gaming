<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if (empty(trim($_POST['id']))) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มีรหัสพนักงาน"]);
        exit;
    } else if (empty($_POST['status'])) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องเลือกสถานภาพพนักงาน"]);
        exit;
    }

    $sql = "UPDATE employees SET emp_out_date=:out,emp_status=:status,emp_note=:note,emp_out_reason=:reason WHERE emp_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'out' => NULL,
        'status' => $_POST['status'],
        'note' => "",
        'reason' => "",
        'id' => $_POST['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "คืนสภาพพนักงาน $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "คืนสภาพพนักงาน $_POST[id] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
