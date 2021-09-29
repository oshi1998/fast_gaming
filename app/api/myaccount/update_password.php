<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    if (empty($_POST['old_password'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาระบุรหัสผ่านเดิมของคุณ"]);
        exit;
    } else if (empty($_POST['new_password'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาระบุรหัสผ่านใหม่ของคุณ"]);
        exit;
    } else if (empty($_POST['confirm_new_password'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณายืนยันรหัสผ่านใหม่ของคุณ"]);
        exit;
    }

    if ($_POST['old_password'] == $_POST['new_password']) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสผ่านเดิม และ รหัสผ่านใหม่ เหมือนกัน"]);
        exit;
    }

    if ($_POST['new_password'] == $_POST['confirm_new_password']) {

        $sql = "UPDATE customers SET cus_password=:password WHERE cus_username=:uname";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT),
            'uname' => $_SESSION['CUSTOMER_USERNAME']
        ]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => "เปลี่ยนรหัสผ่านสำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "เปลี่ยนรหัสผ่านไม่สำเร็จ"]);
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "การยืนยันรหัสผ่านไม่ถูกต้อง"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
