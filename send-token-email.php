<?php
include "connect.php";
require  __DIR__ . "/validate-email.php";
require_once __DIR__ . "/vendor/autoload.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//ini_set('display_errors', 1);

if (isset($_POST['email'])) {


    $email = $_POST['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        exit("Invalid format.");
    }

    if (emailExists($email)) {

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $stmt = $db_connection->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?");
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        if (!$stmt->execute()) {
            //exit("Database error: " . $stmt->error);
            exit("Something went wrong :( Please try again.");
        }

        if ($db_connection->affected_rows) {

            $mail = require __DIR__ . "/mailer.php";
            $reset_url = $_ENV['RESET_PASSWORD_URL'];

            $mail->setFrom($_ENV['MAIL_USERNAME'], 'FilmReviewer');
            $mail->addAddress($email);
            $mail->Subject = 'Reset Password';

            $mail->isHTML(TRUE);
            $mail->Body = '<html><body>Click <a href=' . $reset_url + $token . '">here</a> to reset your password.</body></html>';


            try {
                if (!$mail->send()) {
                    echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent';
                }
            } catch (Exception $e) {
                // echo 'Cannot send the email', $e;
                echo 'Message could not be send. Reload the page and try again!';
            }
        }
    } else {
        echo "No user is registered with this email address!";
    }
}
