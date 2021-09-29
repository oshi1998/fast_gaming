<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    
    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();


    $sql = "SELECT * FROM customers WHERE cus_username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['CUSTOMER_USERNAME']]);
    
    $row = $stmt->fetchObject();

    http_response_code(200);
    echo json_encode(['message'=>"โหลดข้อมูล $_SESSION[CUSTOMER_USERNAME] สำเร็จ",'data'=>$row]);

}else{
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}