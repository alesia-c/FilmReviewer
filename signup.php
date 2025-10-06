<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/signup-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <?php
    include("header.php");
    ?>

    <section class="account-form">

        <?php include "errors.php" ?>

        <div class="form-container">
            <form method="post" action="register_user.php" enctype="multipart/form-data">

                <h3 class="title">Sign Up</h3>
                <p class="placeholder">Username<span>*</span></p>
                <input type="text" name="username" placeholder="Enter your username">

                <p class="placeholder">Email<span>*</span></p>
                <input type="email" name="email" placeholder="Enter your email">

                <p class="placeholder">Password<span>*</span></p>
                <input type="password" name="password" placeholder="Enter your password">

                <p class="placeholder">Confirm Password<span>*</span></p>
                <input type="password" name="c_pass" placeholder="Confirm your password">

                <p class="placeholder">Profile Picture</p>
                <input type="file" name="pfp_pic" accept="image/*">

                <button type="submit" name="register" class="btn">Register Now</button>
                <p class="link">Already have an account? <a href="login.php">Login</a></p>

            </form>
        </div>
    </section>

    <?php
    include("footer.html");
    ?>

</body>
