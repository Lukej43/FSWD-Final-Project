<?php
require_once 'models/database.php';

header('Content-Type: application/json');

$query = "SELECT id, name, created_at FROM stores";
$stmt = $database->prepare($query);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));