<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if ($_SESSION['ADMIN_USERNAME'] != $_GET['username']) {
        $sql = "DELETE FROM users WHERE usr_username=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_GET['username']]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => "ลบข้อมูล $_GET[username] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ลบข้อมูล $_GET[username] ไม่สำเร็จ"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่สามารถลบข้อมูลตัวเองได้"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
