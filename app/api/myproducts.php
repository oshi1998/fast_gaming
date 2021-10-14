<?php

$sql = "SELECT * FROM products,product_types,brands WHERE products.pro_type=product_types.pt_id AND products.pro_brand=brands.brand_id AND pro_status=0 ORDER BY pro_created DESC";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();