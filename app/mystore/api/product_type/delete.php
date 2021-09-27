<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "SELECT pro_id FROM products WHERE pro_brand=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetchAll();

        if(empty($row)){
            $sql = "DELETE FROM product_types WHERE pt_id=?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_GET['id']]);
    
            if ($result) {
                http_response_code(200);
                echo json_encode(['message' => "ลบข้อมูล $_GET[id] สำเร็จ"]);
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ลบข้อมูล $_GET[id] ไม่สำเร็จ"]);
            }
        }else{
            http_response_code(412);
            echo json_encode(['message' => "ไม่สามารถลบได้ เนื่องจากยังมีข้อมูลสินค้าของประเภทรหัส $_GET[id]"]);
            exit;
        }
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ส่งมา"]);
        exit;
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
