<?php

if($_SERVER["REQUEST_METHOD"]=="GET"){
    header("Content-type:application/json");
    session_start();

    if(isset($_SESSION['CART_SHIPPING']) && !empty($_SESSION['CART_SHIPPING'])){
        http_response_code(200);
        echo json_encode(['message'=>"เลือกการจัดส่งแล้ว",'shipping'=>$_SESSION['CART_SHIPPING_ID']]);
    }else{
        http_response_code(412);
        echo json_encode(['message'=>"ยังไม่ได้เลือกการจัดส่ง"]);
    }
}else{
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}