<?php
require "connect.php";

if (isset($_POST['report_id'])) {

    try {
        $reportId = (int) $_POST['report_id'];

        $stmt = $db_connection->prepare("DELETE FROM reports WHERE id = ?");
        $stmt->bind_param("i", $reportId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Report deleted successfully.";
        } else {
            echo "Select a report to delete.";
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
