<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    //ตรวจสอบ $_POST

    if (empty(trim($_POST['id']))) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสพนักงานห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['firstname']))) {
        http_response_code(412);
        echo json_encode(['message' => "ชื่อจริงห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty(trim($_POST['lastname']))) {
        http_response_code(412);
        echo json_encode(['message' => "นามสกุลห้ามเป็นค่าว่าง"]);
        exit;
    } else if (empty($_POST['level'])) {
        http_response_code(412);
        echo json_encode(['message' => "ยังไม่ได้เลือกตำแหน่ง"]);
        exit;
    } else if (empty(trim($_POST['password']))) {
        http_response_code(412);
        echo json_encode(['message' => "รหัสผ่านห้ามเป็นค่าว่าง"]);
        exit;
    }else if (empty($_POST['status'])){
        http_response_code(412);
        echo json_encode(['message' => "ยังไม่ได้เลือกสถานภาพ"]);
        exit;
    }

    $dir = "../../dist/img/emp/$_POST[id]";

    if(!file_exists($dir)){
        mkdir($dir,0777,true);
    }
    

    //ตรวจสอบ $_FILES avatar
    if(!empty($_FILES['avatar']['name'])){

        $file_extention = strrchr($_FILES['avatar']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {
            $avatar_file = uniqid() . $file_extention;
            $upload_dir1 = "../../dist/img/emp/$_POST[id]/$avatar_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดรูปประจำตัว ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    }else{
        $avatar_file = "user.png";
    }

    //ตรวจสอบ $_FILES ID CARD IMG
    if(!empty($_FILES['id_card_img']['name'])){

        $file_extention = strrchr($_FILES['id_card_img']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {
            $id_card_file = uniqid() . $file_extention;
            $upload_dir2 = "../../dist/img/emp/$_POST[id]/$id_card_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดรูปบัตรประชาชน ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    }else{
        $id_card_file = "";
    }

    //ตรวจสอบ $_FILES contract
    if(!empty($_FILES['contract']['name'])){

        $file_extention = strrchr($_FILES['contract']['name'], '.');

        if ($file_extention == ".pdf") {
            $contract_file = uniqid() . $file_extention;
            $upload_dir3 = "../../dist/img/emp/$_POST[id]/$contract_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดสัญญาจ้าง ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .pdf เท่านั้น"]);
            exit;
        }
    }else{
        $contract_file = "";
    }

    $sql = "INSERT INTO employees (emp_id,emp_firstname,emp_lastname,emp_contact,emp_level,emp_password,emp_avatar,emp_id_card_code,emp_id_card_img,emp_join_date,emp_status,emp_contract)
    VALUES (:eid,:firstname,:lastname,:contact,:level,:password,:avatar,:idcc,:idcimg,:join,:status,:contract)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'eid' => $_POST['id'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact'],
        'level' => $_POST['level'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'avatar' => $avatar_file,
        'idcc' => $_POST['id_card_code'],
        'idcimg' => $id_card_file,
        'join' => $_POST['join_date'],
        'status' => $_POST['status'],
        'contract' => $contract_file
    ]);

    if ($result) {

        if (!empty($_FILES['avatar']['name'])) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir1);
        } else if (!empty($_FILES['id_card_img']['name'])) {
            move_uploaded_file($_FILES['id_card_img']['tmp_name'], $upload_dir2);
        } else if (!empty($_FILES['contract']['name'])) {
            move_uploaded_file($_FILES['contract']['tmp_name'], $upload_dir3);
        }

        http_response_code(200);
        echo json_encode(['message' => "เพิ่มข้อมูลพนักงานสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "เพิ่มข้อมูลพนักงานไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
