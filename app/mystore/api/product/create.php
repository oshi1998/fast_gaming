<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty($_FILES['img']['name'])) {
        http_response_code(412);
        echo json_encode(['message' => "ยังไม่ได้อัพโหลดรูปภาพสินค้า"]);
        exit;
    } else if (empty(trim($_POST['id']))) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสสินค้าห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['name']))) {
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

    //ตรวจสอบไฟล์

    $file_extention = strrchr($_FILES['img']['name'], '.');

    if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {
        $file_name = uniqid() . $file_extention;
        $upload_dir = "../../../images/products/$file_name";
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไฟล์อัพโหลดไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
        exit;
    }


    $sql = "INSERT INTO products (pro_id,pro_name,pro_qty,pro_price,pro_type,pro_brand,pro_img) VALUES
    (:id,:name,:qty,:price,:type,:brand,:img)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'qty' => $_POST['qty'],
        'price' => $_POST['price'],
        'type' => $_POST['type'],
        'brand' => $_POST['brand'],
        'img' => $file_name
    ]);

    if ($result) {

        move_uploaded_file($_FILES['img']['tmp_name'],$upload_dir);

        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลสินค้าสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลสินค้าไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
