<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "UPDATE store SET st_facebook=:fb,st_twitter=:tw,st_ig=:ig,st_youtube=:yt,st_line=:line";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'fb' => $_POST['facebook'],
        'tw' => $_POST['twitter'],
        'ig' => $_POST['ig'],
        'yt' => $_POST['youtube'],
        'line' => $_POST['line']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "บันทึกข้อมูล ช่องทางการติดตามอื่นๆ สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "บันทึกข้อมูล ช่องทางการติดตามอื่นๆ ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
