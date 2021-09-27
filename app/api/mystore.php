<?php

$sql = "SELECT * FROM store";
$stmt = $pdo->query($sql);
$store = $stmt->fetchObject();