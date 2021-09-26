<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['username']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อผู้ใช้งานห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['firstname']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อจริงห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['lastname']))) {
        http_response_code(412);
        echo json_encode(['message' => "นามสกุลห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "UPDATE users SET usr_firstname=:firstname,usr_lastname=:lastname,usr_contact=:contact WHERE usr_username=:username";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'username' => $_POST['username'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[username] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[username] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
