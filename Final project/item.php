<?php
require_once 'models/database.php';

header('Content-Type: application/json');

$store_id = $_GET['store_id'] ?? null;

if (!$store_id) {
    echo json_encode(["error" => "store_id required"]);
    exit;
}

$query = "SELECT id, store_id, name, quantity, checked, created_at
          FROM items
          WHERE store_id = :store_id";

$stmt = $database->prepare($query);
$stmt->bindValue(':store_id', $store_id);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));