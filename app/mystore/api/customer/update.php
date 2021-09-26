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
    }

    $sql = "UPDATE customers SET cus_firstname=:fname,cus_lastname=:lname,cus_address=:add,cus_phone=:phone,
    cus_email=:email,cus_gender=:gender WHERE cus_username=:uname";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'fname' => $_POST['firstname'],
        'lname' => $_POST['lastname'],
        'add' => $_POST['address'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'gender' => $_POST['gender'],
        'uname' => $_POST['username']
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
