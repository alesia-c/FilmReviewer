<?php
require "connect.php";
/* 
$id = $_REQUEST['id'];
$sql = "DELETE FROM movies WHERE id=$id ";

if(mysqli_query($db_connection, $sql)){
    echo"<script>alert('Movie added successfully!'); window.location.href='admin.php';</script>";
}
else {
    echo "<script>alert('ERROR: could not delete movie.');";
} */

$id = $_REQUEST['id'] ?? null;

if ($id && is_numeric($id)) {

    $stmt = $db_connection->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Movie deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('ERROR: Could not delete movie.'); window.location.href='admin.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid ID provided.'); window.location.href='admin.php';</script>";
}

$db_connection->close();
?>

