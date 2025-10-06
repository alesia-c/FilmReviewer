<?php
session_start();
include "connect.php";

ini_set('display_errors', 1);

echo "hello from outside function <br>";

if (isset($_POST["submit"])) {

    echo "hello from inside function <br>";

    if (!isset($_POST["reportReason"])) {

        echo "<script>
        alert('Error sending data! Try again later!');
        window.location.href='movies.php';
      </script>";

    } 
    /* elseif (!isset($_SESSION["user_id"])) {

        echo "<script>
        alert('Login to report user!');
        window.location.href='movies.php';
      </script>";
      
    }  */
    else {

        echo "hello everything is ok <br>";

        $reason = $_POST["reportReason"];
        $reason = ucwords(strtolower($reason));
        $reportedUser = $_POST["user"];
        $reportedReview = $_POST["review"];


        echo "Report reason: " . $reason . " <br>";
        echo "The reported: " . $reportedUser . " <br>";

        $query = "INSERT INTO reports (review_id, reason, reported_user_id) VALUES (?, ?, ?)ON DUPLICATE KEY UPDATE report_count = report_count + 1;";
        $insert_stmt = $db_connection->prepare($query);
        $insert_stmt->bind_param("isi", $reportedReview, $reason, $reportedUser);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Thank you for reporting! We will review and take neccessary action.'); window.location.href='movies.php';</script>";
        } else {
            echo "<script>alert('ERROR submiting report.'); window.location.href='movies.php';</script>";
        }

        $insert_stmt->close();
        $stmt->close();
        $db_connection->close();
    }
}
