<?php

if($_SERVER["REQUEST_METHOD"]=="GET"){
    header("Content-type:application/json");
    session_start();

    if(isset($_SESSION['CART_DISCOUNT']) && !empty($_SESSION['CART_DISCOUNT'])){
        http_response_code(200);
        echo json_encode(['message'=>"ใช้โค้ดส่วนลดแล้ว",'discount'=>$_SESSION['CART_DISCOUNT_CODE']]);
    }else{
        http_response_code(412);
        echo json_encode(['message'=>"ยังไม่ได้ใช้โค้ดส่วนลด"]);
    }
}else{
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}