<?php
require_once '../models/database.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';

$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    case 'GET':
        if ($path === 'stores') {
            $stmt = $database->query("SELECT * FROM stores");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else if ($path === 'items' && isset($_GET['store_id'])) {
            $stmt = $database->prepare("SELECT * FROM items WHERE store_id = :id");
            $stmt->bindValue(':id', $_GET['store_id']);
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        if ($path === 'stores') {
            $stmt = $database->prepare("INSERT INTO stores (name) VALUES (:name)");
            $stmt->bindValue(':name', $data['name']);
            $stmt->execute();
            echo json_encode(["message" => "Store added"]);
        } else if ($path === 'items') {
            $stmt = $database->prepare(
                "INSERT INTO items (store_id, name, quantity, checked)
                 VALUES (:store_id, :name, :quantity, 0)"
            );
            $stmt->bindValue(':store_id', $data['store_id']);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':quantity', $data['quantity']);
            $stmt->execute();
            echo json_encode(["message" => "Item added"]);
        }
        break;

    case 'DELETE':
        if ($path === 'items' && isset($_GET['id'])) {
            $stmt = $database->prepare("DELETE FROM items WHERE id = :id");
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->execute();
            echo json_encode(["message" => "Item deleted"]);
        } else if ($path === 'stores' && isset($_GET['id'])) {

            $stmt = $database->prepare("DELETE FROM stores WHERE id = :id");
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->execute();

            echo json_encode(["message" => "Store and its items deleted"]);
        }
        break;

    case 'PUT':
        if ($path === 'items' && isset($_GET['id'])) {
            $stmt = $database->prepare(
                "UPDATE items SET checked = :checked WHERE id = :id"
            );
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->bindValue(':checked', $data['checked']);
            $stmt->execute();
            echo json_encode(["message" => "Item updated"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
}