<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if (isset($_GET['id']) && !empty($_GET['id'])) {

        $sql = "SELECT pro_img FROM products WHERE pro_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetchObject();
        $img = $row->pro_img;

        $sql = "DELETE FROM products WHERE pro_id=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_GET['id']]);

        if ($result) {

            $delete_dir = "../../../images/products/$img";
            if(file_exists($delete_dir)){
                unlink($delete_dir);
            }

            http_response_code(200);
            echo json_encode(['message' => "ลบข้อมูล $_GET[id] สำเร็จ"]);
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ลบข้อมูล $_GET[id] ไม่สำเร็จ"]);
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
