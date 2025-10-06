<?php
require "connect.php";

if (isset($_POST['user_id'])) {

    try {
        $userId = (int) $_POST['user_id'];

        $db_connection -> begin_transaction();
        
        $stmt1 = $db_connection->prepare("DELETE FROM reviews WHERE user_id = ?");
        $stmt1->bind_param("i", $userId);
        $stmt1->execute();
        
        $stmt2 = $db_connection->prepare("DELETE FROM users WHERE id = ?");
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();

        $db_connection->commit();
        echo "Account deleted successfully.";

        $stmt1->close();
        $stmt2->close();
        $db_connection->close();

    } 
    catch (Exception) {
        $db_connection->rollback();
        echo "Something went wrong. Could not delete account.";
    }   
} 
else {
    echo "No account ID received.";
}
