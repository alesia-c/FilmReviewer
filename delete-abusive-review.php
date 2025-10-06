<?php
require "connect.php";

if (isset($_POST['review_id'])) {

    try {
        $reviewId = (int) $_POST['review_id'];

        $stmt = $db_connection->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Review deleted successfully.";
        } else {
            echo "Select a review to delete.";
        }

        $stmt->close();

    } 
    catch (Exception) {
        echo "Something went wrong.";
    }   
} 
else {
    echo "No report ID received.";
}
