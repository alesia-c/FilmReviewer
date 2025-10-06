<?php
require "connect.php";

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing ID']);
    exit;
} 
$id = intval($_GET['id']);

if ($db_connection->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection error']);
    exit;
}

$stmt = $db_connection->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($item = $result->fetch_assoc()) {
    echo json_encode($item);  
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Item not found']);
}

$stmt->close();
$db_connection->close();
?>
