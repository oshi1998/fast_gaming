<?php

require_once('connect.php');

$sql = "SELECT * FROM store";
$stmt = $pdo->query($sql);
$store = $stmt->fetchObject();