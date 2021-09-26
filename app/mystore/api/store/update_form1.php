<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['name']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อร้านห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['address']))) {
        http_response_code(412);
        echo json_encode(['message' => "ที่อยู่ร้านห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['phone']))) {
        http_response_code(412);
        echo json_encode(['message' => "เบอร์โทรร้านห้ามเป็นค่าว่าง"]);
        exit;
    }

    //ตรวจสอบ $_FILES การอัพโหลด LOGO
    if (!empty($_FILES['logo']['name'])) {

        $file_extention = strrchr($_FILES['logo']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {

            if ($_POST['old_logo'] != "") {

                $delete_dir = "../../../images/" . $_POST['old_logo'];

                if (file_exists($delete_dir)) {
                    unlink($delete_dir);
                }
            }
            $file_name = uniqid() . $file_extention;
            $upload_dir = "../../../images/" . $file_name;
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    } else {
        $file_name = $_POST['old_logo'];
    }


    $sql = "UPDATE store SET st_name=:name,st_address=:add,st_phone=:phone,st_email=:email,st_logo=:logo";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'add' => $_POST['address'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'logo' => $file_name
    ]);

    if ($result) {
        if (!empty($_FILES['logo']['name'])) {
            move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir);
        }
        http_response_code(200);
        echo json_encode(['message' => "บันทึกข้อมูลพื้นฐานร้านสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "บันทึกข้อมูลพื้นฐานร้านไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
