<?php


header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';

$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    case 'GET':
        if ($path === 'store') {
            $stmt = $database->query("SELECT * FROM store");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else if ($path === 'items' && isset($_GET['store_id'])) {
            $stmt = $database->prepare("SELECT * FROM items WHERE store_id = :id");
            $stmt->bindValue(':id', $_GET['store_id']);
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        else if ($path === 'items') {

        $stmt = $database->query("SELECT * FROM items");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    }
        break;

    case 'POST':
        if ($path === 'store') {
            $stmt = $database->prepare("INSERT INTO store (name) VALUES (:name)");
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
        } else if ($path === 'store' && isset($_GET['id'])) {

            $stmt = $database->prepare("DELETE FROM store WHERE id = :id");
            $stmt->bindValue(':id', $_GET['id']);
            $stmt->execute();

            echo json_encode(["message" => "Store deleted"]);
        }
        break;

    case 'PUT':
    if ($path === 'items' && isset($_GET['id'])) {
        $stmt = $database->prepare(
            "UPDATE items
             SET checked = :checked,
                 name = :name,
                 quantity = :quantity
             WHERE id = :id"
        );

        $stmt->bindValue(':id', $_GET['id']);
        $stmt->bindValue(':checked', $data['checked']);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':quantity', $data['quantity']);

        $stmt->execute();

        echo json_encode(["message" => "Item updated"]);
    }
    break;

    default:
        echo json_encode(["error" => "Invalid request"]);
}