<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/forgot-password-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <?php
    include("header.php");
    ?>

    <section>

        <h1>
            Forgot Password
        </h1>

        <form id="resetForm">
            <input type="text" name="email" placeholder="Enter your email" required>
            <button type="submit">Submit</button>
        </form>

        <div id="responseMessage"></div>

        <!--      <form method="post" action="send-token-email.php">

            <input type="text" name="email" placeholder="Enter your email" required>
            <button name="submit">Submit</button>

        </form> -->

    </section>

    <?php
    include "footer.html";
    ?>

    <script>
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent page reload

            const form = e.target;
            const formData = new FormData(form);

            fetch('send-token-email.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = data;
                })
                .catch(err => {
                    document.getElementById('responseMessage').innerHTML = 'An error occurred.';
                    console.error(err);
                });
        });
    </script>

</body>