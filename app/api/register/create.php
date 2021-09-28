<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-type:application/json");
    require_once('../connect.php');

    if (empty($_POST['firstname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อจริง']);
        exit;
    } else if (empty($_POST['lastname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลนามสกุล']);
        exit;
    } else if (empty($_POST['gender'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณาเลือกเพศ']);
        exit;
    } else if (empty($_POST['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้งาน']);
        exit;
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
        exit;
    } else if (empty($_POST['confirm_password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกยืนยันรหัสผ่าน']);
        exit;
    } else if (empty($_POST['acceptCheck'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณายอมรับ ข้อกำหนดเงื่อนไข และ นโยบายส่วนบุคคล']);
        exit;
    }

    if ($_POST['password'] == $_POST['confirm_password']) {

        $sql = "INSERT INTO customers (cus_firstname,cus_lastname,cus_phone,cus_gender,cus_username,cus_password) VALUES 
        (:firstname,:lastname,:phone,:gender,:username,:password)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'phone' => $_POST['phone'],
            'gender' => $_POST['gender'],
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        if ($result) {

            session_start();
            $_SESSION['CUSTOMER_USERNAME'] = $_POST['username'];
            $_SESSION['CUSTOMER_FIRSTNAME'] = $_POST['firstname'];
            $_SESSION['CUSTOMER_LASTNAME'] = $_POST['lastname'];

            http_response_code(200);
            echo json_encode(['status' => true, 'message' => 'ลงทะเบียนสำเร็จ']);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['status' => false, 'message' => 'ลงทะเบียนไม่สำเร็จ']);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'การยืนยันรหัสผ่านไม่ตรงกัน']);
        exit;
    }
} else {
    http_response_code(405);
    echo "Request ไม่ถูกต้อง";
}
