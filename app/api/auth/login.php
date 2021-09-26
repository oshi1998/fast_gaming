<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if (empty($_POST['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้งาน']);
        exit;
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
        exit;
    }

    $sql = "SELECT * FROM customers WHERE cus_username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $row = $stmt->fetchObject();

    if (!empty($row)) {

        if (password_verify($_POST['password'], $row->cus_password)) {

            session_start();
            $_SESSION['CUSTOMER_USERNAME'] = $row->cus_username;
            $_SESSION['CUSTOMER_FIRSTNAME'] = $row->cus_firstname;
            $_SESSION['CUSTOMER_LASTNAME'] = $row->cus_lastname;

            http_response_code(200);
            echo json_encode(['status' => true, 'message' => 'เข้าสู่ระบบสำเร็จ']);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        exit;
    }
} else {
    http_response_code(405);
    echo "Request ไม่ถูกต้อง";
}
