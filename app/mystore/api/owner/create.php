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
    } else if (empty(trim($_POST['password']))) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสผ่านห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "INSERT INTO users (usr_username,usr_firstname,usr_lastname,usr_contact,usr_password,usr_level)
    VALUES (:username,:firstname,:lastname,:contact,:password,:level)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'username' => $_POST['username'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact'],
        'password' => password_hash($_POST['password'],PASSWORD_DEFAULT),
        'level' => "เจ้าของร้าน"
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลเจ้าของร้านสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลเจ้าของร้านไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
