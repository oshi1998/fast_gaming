<?php

if($_SERVER['REQUEST_METHOD']=="GET"){
    header("Content-type:application/json");

    session_start();

    if(isset($_SESSION['CART_DISCOUNT']) && !empty($_SESSION['CART_DISCOUNT'])){

        $_SESSION['CART_NET'] += $_SESSION['CART_DISCOUNT'];
        $_SESSION['CART_DISCOUNT'] = 0;
        unset($_SESSION['CART_DISCOUNT_CODE']);

        http_response_code(200);
        echo json_encode(['message'=>"ยกเลิกโค้ดส่วนลดสำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['message'=>"ไม่มีโค้ดส่วนลด"]);
        exit;
    }
}else{
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}