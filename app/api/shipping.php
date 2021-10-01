<?php

$sql = "SELECT * FROM shipping";
$stmt = $pdo->query($sql);
$shipping = $stmt->fetchAll();