<?php

session_start();

require_once realpath(__DIR__ . "/vendor/autoload.php");
// require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope('email');
$client->addScope('profile');

$loginUrl = $client->createAuthUrl();

header('Location: ' . filter_var($loginUrl, FILTER_SANITIZE_URL));
exit();
