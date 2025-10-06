<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/reset-password-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <?php
    include("header.php");
    ?>

    <div class="form-container">

        <h1>Reset Password</h1>

        <?php
        $token = $_GET['token'] ?? '';
        ?>

        <form id="reset-password-form" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label for="password">New password</label>
            <input type="password" id="password" name="password" required pattern=".{8,}" title="Password must be at least 8 characters long">
            <br>

            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <br>

            <button type="submit">Reset</button>
        </form>

        <div id="message"></div>

    </div>

    <?php
    include("footer.html");
    ?>

    <script>
        document.getElementById("reset-password-form").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this); 

            fetch('save-new-password.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) 
                .then(data => {
                    if (data.success) {
                        document.getElementById("message").innerHTML = '<div style="color: green; padding: 10px;">' + data.message + '</div>';
                        setTimeout(() => window.location.href = 'login.php', 2000);
                    } else {
                        document.getElementById("message").innerHTML = '<div style="color: red; padding: 10px;">' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    document.getElementById("message").innerHTML = '<div style="color: red; padding: 10px;">Something went wrong. Please try again later.</div>';
                });
        });
    </script>

</body>

</html>