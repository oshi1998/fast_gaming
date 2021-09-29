<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();


    $sql = "UPDATE customers SET cus_address=:add,cus_phone=:phone 
    WHERE cus_username=:uname";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'add' => $_POST['address'],
        'phone' => $_POST['phone'],
        'uname' => $_SESSION['CUSTOMER_USERNAME']
    ]); 

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => "อัพเดตข้อมูลสำหรับจัดส่งสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตข้อมูลสำหรับจัดส่งไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
