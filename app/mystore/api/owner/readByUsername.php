<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if (isset($_GET['username']) && !empty($_GET['username'])) {

        $sql = "SELECT * FROM users WHERE usr_username = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$_GET['username']]);

        if ($result) {

            $row = $stmt->fetchObject();

            if (!empty($row)) {
                http_response_code(200);
                echo json_encode(['message' => "โหลดข้อมูล $_GET[username] สำเร็จ",'data'=>$row]);
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ไม่มีข้อมูล $_GET[username]"]);
            }

        } else {
            http_response_code(412);
            echo json_encode(['message' => "Query ไม่ผ่าน"]);
        }

        
    } else {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี USERNAME ถูกส่งมา"]);
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
