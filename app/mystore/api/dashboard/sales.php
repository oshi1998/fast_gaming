<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type:application/json");
    require_once("../connect.php");

    function MonthThai($strDate) //ฟังก์ชั่นแปลงเดือนภาษาไทย
    {
        $strMonth = date("n", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strMonthThai";
    }


    for ($i = 1; $i <= 6; $i++) { //สร้างวันที่ 6 เดือนหลังสุด
        $months[] = date("n", strtotime(date('Y-m-01') . " -$i months"));
    }

    $sql = "SELECT * FROM product_types";
    $stmt = $pdo->query($sql);
    $types = $stmt->fetchAll();

    $i = 0;

    foreach ($months as $month) {
        foreach ($types as $type) {
            $sql = "SELECT pt_name,SUM(odd_amount) AS amount,MONTH(od_created) as month FROM orders,order_details,products,product_types
            WHERE orders.od_id=order_details.odd_od_id AND order_details.odd_pro_id=products.pro_id AND products.pro_type=product_types.pt_id
            AND MONTH(od_created) = :month
            AND pt_id = :pt_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'month' => $month,
                'pt_id' => $type['pt_id']
            ]);

            $row = $stmt->fetchObject();

            if ($row->amount == NULL) {
                $amount = 0;
            } else {
                $amount = $row->amount;
            }

            $data[$i][] = $amount;
        }
        $i++;
    }


    $months = [];
    for ($i = 1; $i <= 6; $i++) { //สร้างวันที่ 6 เดือนหลังสุด
        $months[] = MonthThai(date("Y-m-d", strtotime(date('Y-m-01') . " -$i months")));
    }

    http_response_code(200);
    echo json_encode(['message' => "สำเร็จ", 'types' => $types, 'months' => $months, 'data' => $data]);
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
