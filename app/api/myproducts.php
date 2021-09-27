<?php

$sql = "SELECT * FROM products,product_types,brands WHERE products.pro_type=product_types.pt_id AND products.pro_brand=brands.brand_id";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();