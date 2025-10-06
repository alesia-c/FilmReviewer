<?php
require "connect.php";
//ini_set('display_errors', 1);


if (isset($_POST["add"])) {
    // Collect form data
    $title = trim($_POST["title"]);
    $trailer = trim($_POST["trailer"]);
    $year = trim($_POST["year"]);
    $duration = trim($_POST["duration"]);
    $rev_description = trim($_POST["description"]);

    // Handle Image Upload
    if (!isset($_FILES['cover']) || $_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
        die("<script>alert('Error: No image uploaded or upload failed.'); window.location.href='admin.php';</script>");
    }

    $image_name = basename($_FILES['cover']['name']);
    $image_tmp = $_FILES['cover']['tmp_name'];
    $image_folder = "imazhet/";
    $image_path = $image_folder . $image_name;

    // Move the uploaded file
    if (!move_uploaded_file($image_tmp, $image_path) ) {
        die("<script>alert('Error moving image to target folder:'); window.location.href='admin.php';</script>");
    } 

    // Ensure file was successfully uploaded
    if (!file_exists($image_path)) {
        die("<script>alert('Error: Image file not saved.'); window.location.href='admin.php';</script>");
    }

    // Check if the movie already exists in the database
    $stmt = $db_connection->prepare("SELECT name, trailer FROM movies WHERE name=? OR trailer=?");
    $stmt->bind_param("ss", $title, $trailer);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        if ($row["name"] === $title) {
            echo "<script>alert('Movie with the same title already exists.'); window.location.href='admin.php';</script>";
            exit;
        } elseif ($row["trailer"] === $trailer) {
            echo "<script>alert('This trailer belongs to another movie.'); window.location.href='admin.php';</script>";
            exit;
        }
    }

    // Insert movie into database
    $insert_stmt = $db_connection->prepare("INSERT INTO movies (name, image, trailer, year, duration, description) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssssss", $title, $image_path, $trailer, $year, $duration, $rev_description);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Movie added successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('ERROR: " . $db_connection->error . "'); window.location.href='admin.php';</script>";
    }

    // Close statements and connection
    $insert_stmt->close();
    $stmt->close();
    $db_connection->close();
}
?>