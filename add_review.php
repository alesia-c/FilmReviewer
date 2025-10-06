<?php
session_start();
require "connect.php";

if (isset($_POST["submit_review"])) {
    // Te sigurohemi qe movie_id eshte kaluar
    if (!isset($_POST['movie_id']) || !isset($_SESSION["user_id"])) {
        echo "<script>
        alert('Log in to leave a review!');
        window.location.href='movies.php';
      </script>";
        die("Movie ID is missing!");
    }
    else {
        $movie_id = $_POST['movie_id'];
        $user_ID = $_SESSION['user_id'];
        $movie_rating = $_POST['rating'];
        $review_desc = $_POST['rev_desc'];
    
        echo "Movie ID: " . htmlspecialchars($movie_id); // Kontrollo output
       
        $stmt = $db_connection->prepare("INSERT INTO reviews (movie_id, user_id, rating, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $movie_id, $user_ID, $movie_rating, $review_desc);
    
        if ($stmt->execute()) {
            echo "<script>
                    alert('Review added successfully!');
                    window.location.href='movies.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    }
}