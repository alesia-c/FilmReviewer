<?php
require "connect.php";
//ini_set('display_errors', 1);

if (isset($_POST["update"])) {

    $movie_id = intval($_POST["movie_id"]); 
    $title = trim($_POST["title"]);
    $trailer = trim($_POST["trailer"]);
    $year = trim($_POST["year"]);
    $duration = trim($_POST["duration"]);
    $rev_description = trim($_POST["description"]);

    $image_path = null;

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['cover']['name']);
        $image_tmp = $_FILES['cover']['tmp_name'];
        $image_folder = "imazhet/";
        $image_path = $image_folder . $image_name;

        if (!move_uploaded_file($image_tmp, $image_path)) {
            die("<script>alert('Error moving image to target folder'); window.location.href='admin.php';</script>");
        }
    } else {
        // mban imazhin ekzistues
        $stmt = $db_connection->prepare("SELECT cover FROM movies WHERE id = ?");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $image_path = $row['cover'];
        }
        $stmt->close();
    }

    $update_stmt = $db_connection->prepare("
        UPDATE movies 
        SET name = ?, image = ?, trailer = ?, year = ?, duration = ?, description = ? 
        WHERE id = ?
    ");
    $update_stmt->bind_param("ssssssi", $title, $image_path, $trailer, $year, $duration, $rev_description, $movie_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Movie: {$movie_id} updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('ERROR: " . $db_connection->error . "'); window.location.href='admin.php';</script>";
    }

    $update_stmt->close();
    $db_connection->close();
}
?>
