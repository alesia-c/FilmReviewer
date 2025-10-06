<?php 
session_start();
require("connect.php"); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Movies</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/movies-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <?php
    include("header.php");
    ?>

    <section class="all-movies">

        <div class="content-container">

            <?php
            $query = "SELECT id, name, image, year, duration FROM `movies`";
            $result = mysqli_query($db_connection, $query) or die("Error executing string");

            $n = mysqli_num_rows($result);

            for ($i = 0; $i < $n; $i++) {
                $movie = mysqli_fetch_array($result);
            ?>
                <div class="movie-con">
                    <img src="<?php echo $movie['image']; ?>">
                    <h4><?php echo $movie['name']; ?></h4>
                    <div class="sub-container">
                        <p><?php echo $movie['year'], " - ", $movie['duration'], "m" ?></p>
                        <button onclick="window.location.href='movie-page.php?get_id=<?= $movie['id']; ?>'" class="more-button">More</button>           
                    </div>
                </div>
            <?php
            }
            ?>

        </div>

    </section>

    <?php
    include("footer.html");
    ?>

</body>