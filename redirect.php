<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/validate-email.php';
include "connect.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']); 

if (! isset($_GET["code"])) {
    exit("Login Failed.");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);
$userInfo = $oauth->userinfo->get();

session_start();
$_SESSION['login'] = true;
$_SESSION['username'] = $userInfo->name;

// regjistrojme perdoruesin ne database nese nuk ekziston
if (emailExists($userInfo->email)) {
    $_SESSION['user_id'] = getUserId($userInfo->email);
    header("Location: index.php");
    exit();     // nese perdoruesi ekziston vazhdon ne homepage
}

try {

    echo "trying to redister in db <br>";
    $pass = "";
    $image_path = "imazhet/default-pfp.jpg";
    $insert_stmt = $db_connection->prepare("INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $userInfo->name, $userInfo->email, $pass, $image_path);

    if ($insert_stmt->execute()) {
        $_SESSION['user_id'] = getUserId($userInfo->email);
        echo "<script>alert('User  registered successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('ERROR: " . $db_connection->error . "'); window.location.href='index.php';</script>";
    }

} catch (Exception $e) {
    echo "Could not redister in db <br>";
    echo $e;
}

function getUserId($email)
{
    include "connect.php";

    $user_id;

    $select_stmt = $db_connection->prepare("SELECT id FROM users WHERE email = ?");
    $select_stmt->bind_param("s", $email);
    $select_stmt->execute();
    $select_stmt->store_result();

    if ($select_stmt->num_rows > 0) {
        $select_stmt->bind_result($user_id);
        $select_stmt->fetch();

        return $user_id;
    } else {
        return 0;
    }
}