<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    if (empty($_POST['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้งาน']);
        exit();
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
        exit();
    }

    $sql = "SELECT usr_username,usr_firstname,usr_lastname,usr_password,usr_level FROM users WHERE usr_username=:uname
    UNION SELECT emp_id,emp_firstname,emp_lastname,emp_password,emp_level FROM employees WHERE emp_id=:uname ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'uname' => $_POST['username']
    ]);
    $row = $stmt->fetchObject();

    if (!empty($row)) {

        if (password_verify($_POST['password'], $row->usr_password)) {

            session_start();
            $_SESSION['ADMIN_USERNAME'] = $row->usr_username;
            $_SESSION['ADMIN_FIRSTNAME'] = $row->usr_firstname;
            $_SESSION['ADMIN_LASTNAME'] = $row->usr_lastname;
            $_SESSION['ADMIN_LEVEL'] = $row->usr_level;

            http_response_code(200);
            echo json_encode(['status' => true, 'message' => 'เข้าสู่ระบบสำเร็จ']);
            exit();
        } else {
            http_response_code(401);
            echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
            exit();
        }
    } else {
        http_response_code(401);
        echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        exit();
    }
} else {
    http_response_code(405);
    echo "Request ไม่ถูกต้อง";
}
