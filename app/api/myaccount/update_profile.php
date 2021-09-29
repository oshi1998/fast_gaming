<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    if (empty($_POST['firstname'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาระบุชื่อจริงของคุณ"]);
        exit;
    } else if (empty($_POST['lastname'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาระบุนามสกุลของคุณ"]);
        exit;
    }


    $sql = "UPDATE customers SET cus_firstname=:fname,cus_lastname=:lname,cus_email=:email,cus_gender=:gender 
    WHERE cus_username=:uname";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'fname' => $_POST['firstname'],
        'lname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'gender' => $_POST['gender'],
        'uname' => $_SESSION['CUSTOMER_USERNAME']
    ]);

    if ($result) {
        $_SESSION['CUSTOMER_FIRSTNAME'] = $_POST['firstname'];
        $_SESSION['CUSTOMER_LASTNAME'] = $_POST['lastname'];
        http_response_code(200);
        echo json_encode(['message' => "อัพเดตโปรไฟล์สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตโปรไฟล์ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
