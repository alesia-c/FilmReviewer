<?php
require "connect.php";
ini_set('display_errors', 1);

if (isset($_POST['user_id'])) {

    try {
        $userId = (int) $_POST['user_id'];

        $suspendedUntil = date('Y-m-d', strtotime('+1 month'));

        $stmt = $db_connection->prepare("UPDATE users SET status = 'Suspended', suspended_until = ? WHERE id = ?");
        $stmt->bind_param("si", $suspendedUntil, $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Account suspended successfully.";
        } else {
            echo "Select an account to suspend.";
        }

        $stmt->close();
    } catch (Exception) {
        echo "Something went wrong.";
    }
} else {
    echo "No account ID received.";
}
