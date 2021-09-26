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
    }

    $dir = "../../dist/img/emp/$_POST[id]";

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }


    //ตรวจสอบ $_FILES avatar
    if (!empty($_FILES['avatar']['name'])) {

        $file_extention = strrchr($_FILES['avatar']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {

            if ($_POST['old_avatar'] != "user.png") {
                $delete_dir = "../../dist/img/emp/$_POST[id]/$_POST[old_avatar]";
                unlink($delete_dir);
            }

            $avatar_file = uniqid() . $file_extention;
            $upload_dir1 = "../../dist/img/emp/$_POST[id]/$avatar_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดรูปประจำตัว ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    } else {
        $avatar_file = $_POST['old_avatar'];
    }

    //ตรวจสอบ $_FILES ID CARD IMG
    if (!empty($_FILES['id_card_img']['name'])) {

        $file_extention = strrchr($_FILES['id_card_img']['name'], '.');

        if ($file_extention == ".png" || $file_extention == ".jpg" || $file_extention == ".jpeg") {

            if ($_POST['old_id_card_img'] != "") {
                $delete_dir = "../../dist/img/emp/$_POST[id]/$_POST[old_id_card_img]";
                unlink($delete_dir);
            }

            $id_card_file = uniqid() . $file_extention;
            $upload_dir2 = "../../dist/img/emp/$_POST[id]/$id_card_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดรูปบัตรประชาชน ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .png .jpg .jpeg เท่านั้น"]);
            exit;
        }
    } else {
        $id_card_file = $_POST['old_id_card_img'];
    }

    //ตรวจสอบ $_FILES contract
    if (!empty($_FILES['contract']['name'])) {

        $file_extention = strrchr($_FILES['contract']['name'], '.');

        if ($file_extention == ".pdf") {

            if ($_POST['old_contract'] != "") {
                $delete_dir = "../../dist/img/emp/$_POST[id]/$_POST[old_contract]";
                unlink($delete_dir);
            }

            $contract_file = uniqid() . $file_extention;
            $upload_dir3 = "../../dist/img/emp/$_POST[id]/$contract_file";
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไฟล์อัพโหลดสัญญาจ้าง ไม่ถูกต้อง ต้องเป็นไฟล์ภาพ นามสกุล .pdf เท่านั้น"]);
            exit;
        }
    } else {
        $contract_file = $_POST['old_contract'];
    }

    $sql = "UPDATE employees SET emp_firstname=:firstname,emp_lastname=:lastname,emp_contact=:contact,emp_level=:level,
    emp_avatar=:avatar,emp_id_card_code=:idcc,emp_id_card_img=:idcimg,emp_join_date=:join,emp_status=:status,emp_contract=:contract
    WHERE emp_id=:eid";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'eid' => $_POST['id'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact'],
        'level' => $_POST['level'],
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
        echo json_encode(['message' => "อัพเดต $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['message' => "อัพเดต $_POST[id] ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
