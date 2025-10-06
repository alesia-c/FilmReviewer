<?php
session_start();
include 'connect.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        $user_check_query = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_prepare($db_connection, $user_check_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password']) && strcasecmp($user['status'], 'Active') === 0) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
 
            if ($_SESSION['username'] !== "sys_admin") {
                echo "<script>alert('Login Successful!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Login Successful!'); window.location.href='admin.php';</script>";
            }
            exit();
        } 
        else if (strcasecmp($user['status'], 'Suspended') === 0){
            echo "<script>alert('Your account has been suspended until: {$user['suspended_until']} for failing to comply with our terms of service.');</script>";
        }
        else {
            echo "<script>alert('Incorrect username or password.');</script>";
        } 
/* 
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
 
            if ($_SESSION['username'] !== "sys_admin") {
                echo "<script>alert('Login Successful!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Login Successful!'); window.location.href='admin.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Incorrect username or password.');</script>";
        } 
*/

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login-style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <section>
        <div class="form-container">
            <p class="title">Login</p>
            <form class="form" method="post" action="">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <a href="forgot-password.php" class="forgot">Forgot password?</a>

                <button type="submit" name="login" class="sign">Log in</button>
            </form>

            <p class="signup">Continue with <a href="continue-with-google.php">Google</a></p>

            <p class="signup">Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </section>
    <?php include("footer.html"); ?>
</body>

</html>