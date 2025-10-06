<?php
include "connect.php";
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST["token"], $_POST["password"], $_POST["password_confirmation"])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$token_from_url = $_POST["token"];  
$password = $_POST["password"];  
$password_confirmation = $_POST["password_confirmation"];  

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long.']);
    exit;
}

if ($password !== $password_confirmation) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
}

$token_hash_from_url = hash('sha256', $token_from_url);

$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
$stmt = $db_connection->prepare($sql);
$stmt->bind_param("s", $token_hash_from_url);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
    exit;
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo json_encode(['success' => false, 'message' => 'Token has expired.']);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
$stmt = $db_connection->prepare($sql);
$stmt->bind_param("si", $password_hash, $user["id"]);
$stmt->execute();

if ($stmt->affected_rows) {
    echo json_encode(['success' => true, 'message' => 'Your password has been successfully reset.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Password update failed. Please try again later.']);
}

exit;
?>
