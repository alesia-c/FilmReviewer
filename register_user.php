<?php
require "connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$errors = array();

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($db_connection, $_POST['username']);
    $email = mysqli_real_escape_string($db_connection, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db_connection, $_POST['password']);
    $password_2 = mysqli_real_escape_string($db_connection, $_POST['c_pass']);
    $image_path = "";

    // kontrolli i inputeve
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (isset($_FILES['pfp_pic']) && $_FILES['pfp_pic']['error'] == 0) {
        $image_name = $_FILES['pfp_pic']['name'];
        $image_folder = "imazhet/";
        $image_path = $image_folder . basename($image_name);
    }
    else{
        $image_path = "imazhet/default-pfp.jpg";
    }

    // kontrollon nese ekziston nje user me te njejtat te dhena
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($db_connection, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // regjistrimi ne database 
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT); //enkriptimi i passwordit

        $query = "INSERT INTO users (username, email, password, image) VALUES ('$username', '$email', '$password', '$image_path')";
        if (mysqli_query($db_connection, $query)) {
           // session_start();
           //$_SESSION['login'] = true;
           // $_SESSION['user_id'] = getUserId($username);
            echo "<script>
                    alert('User registered successfully!');
                    window.location.href='login.php';
                </script>"; 
        } else {
            echo "ERROR connecting to database.";
        }
    } else {  // bashkon elementet e array-t ne nje stringe
        echo "<script>alert('ERROR: " . implode(". ", $errors) . "'); 
        window.location.href='signup.php';
        </script>";
    }
} else {
    echo "<script>
                    alert('Form is empty. Cannot submit.');
                    window.location.href='signup.php';
            </script>";
}
