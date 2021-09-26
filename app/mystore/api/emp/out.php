<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if (empty(trim($_POST['note']))) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องระบุสาเหตุของการพ้นสภาพพนักงาน"]);
        exit;
    } else if (empty($_POST['out_date'])) {
        http_response_code(412);
        echo json_encode(['message' => "ต้องวันที่ของการพ้นสภาพพนักงาน"]);
        exit;
    }

    $sql = "UPDATE employees SET emp_out_date=:out,emp_status=:status,emp_note=:note WHERE emp_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'out' => $_POST['out_date'],
        'status' => "พ้นสภาพพนักงาน",
        'note' => $_POST['note'],
        'id' => $_POST['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "พ้นสภาพพนักงาน $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "พ้นสภาพพนักงาน $_POST[id] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
