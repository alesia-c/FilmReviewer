<?php 

require_once realpath(__DIR__ . "/vendor/autoload.php");
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$server = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD']; 

$db_connection = mysqli_connect($server, $user, $password, $db_name);

?>