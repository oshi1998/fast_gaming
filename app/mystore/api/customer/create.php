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
    } else if (empty($_POST['gender'])) {
        http_response_code(412);
        echo json_encode(['message' => 'ยังไม่ได้เลือกเพศ']);
        exit;
    } else if (empty(trim($_POST['password']))) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสผ่านห้ามเป็นค่าว่าง"]);
        exit;
    }

    $sql = "INSERT INTO customers (cus_username,cus_firstname,cus_lastname,cus_address,cus_phone,cus_email,cus_gender,cus_password) VALUES 
        (:uname,:fname,:lname,:add,:phone,:email,:gender,:pass)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'uname' => $_POST['username'],
        'fname' => $_POST['firstname'],
        'lname' => $_POST['lastname'],
        'add' => $_POST['address'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'gender' => $_POST['gender'],
        'pass' => password_hash($_POST['password'],PASSWORD_DEFAULT)
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลลูกค้าสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลลูกค้าไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
