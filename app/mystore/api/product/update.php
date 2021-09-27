<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อสินค้าห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['qty']))) {
        http_response_code(412);
        echo json_encode(['message' => "จำนวนสินค้าห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['price']))) {
        http_response_code(412);
        echo json_encode(['message' => "ราคาสินค้าห้ามเป็นค่าว่าง"]);
        exit;
    }

    //ตรวจสอบ $_FILES การอัพโหลด IMG
    if (!empty($_FILES['img']['name'])) {

        $file_extention = strrchr($_FILES['img']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {

            $delete_dir = "../../../images/products/$_POST[old_img]";

            if (file_exists($delete_dir)) {
                unlink($delete_dir);
            }

            $file_name = uniqid() . $file_extention;
            $upload_dir = "../../../images/products/$file_name";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    } else {
        $file_name = $_POST['old_img'];
    }

    $sql = "UPDATE products SET pro_name=:name,pro_detail=:detail,pro_qty=:qty,pro_price=:price,
    pro_type=:type,pro_brand=:brand,pro_img=:img WHERE pro_id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'detail' => $_POST['detail'],
        'qty' => $_POST['qty'],
        'price' => $_POST['price'],
        'type' => $_POST['type'],
        'brand' => $_POST['brand'],
        'img' => $file_name,
        'id' => $_POST['id']
    ]);

    if ($result) {
        if(!empty($_FILES['img']['name'])){
            move_uploaded_file($_FILES['img']['tmp_name'],$upload_dir);
        }
        http_response_code(200);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดตข้อมูล $_POST[id] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
