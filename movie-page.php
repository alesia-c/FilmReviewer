<?php require "connect.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/movie-page-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <?php
    include("header.php");
    ?>

    <?php
    if (isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
        $GLOBALS['movie_ID'] = $get_id;
    } else {
        $get_id = '';
        header('location:movies.php');
    }

    $query = "SELECT name, trailer, year, duration, rating, description FROM `movies` WHERE id = $get_id";
    $result = mysqli_query($db_connection, $query) or die("Error executing string");
    $movie = mysqli_fetch_array($result);
    ?>

    <section>

        <div class="trailer">
            <iframe src="<?php echo $movie['trailer'] ?>&autoplay=1&mute=1&controls=1&showinfo=0&controls=0"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
        </div>

        <div class="info-container">
            <h1><?php echo $movie['name'] ?></h1>
            <div class="info">
                <p><?php echo $movie['year'] . " - " . $movie['duration'] . "m" ?></p>
                <span>
                    <p>
                        <i class="fas fa-star"></i>
                        <?php echo $movie['rating'] ?>/5
                    </p>
                </span>
            </div>
        </div>

        <p class="description"><?php echo $movie['description'] ?></p>

    </section>

    <section class="add-review">

        <form method="post" action="add_review.php">
            <div class="rating-container">
                <label for="rating">Rate: </label>
                <select name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="submit" name="submit_review">Add Review</button>
                <input type="hidden" value="<?php echo $get_id ?>" name="movie_id">
            </div>
            <textarea name="rev_desc" autocapitalize="on" placeholder="Write your review here..." required></textarea>
        </form>

    </section>

    <section class="reviews">

        <h1>User Reviews</h1>

        <?php
        $query = "SELECT review_id, user_id, image, username, date, rating, description FROM `movie_reviews` WHERE movie_id = $get_id";
        $results = mysqli_query($db_connection, $query) or die("Error executing string");

        $rows = mysqli_num_rows($results);

        for ($i = 0; $i < $rows; $i++) {
            $review = mysqli_fetch_array($results);
        ?>
            <div class="review-container">

                <div class="review-header">

                    <img src="<?php echo $review['image']; ?>" alt="User Profile Pic">

                    <div class="review-user-info">
                        <span class="username"><?php echo $review['username']; ?></span>
                        <span class="date"><?php echo $review['date']; ?></span>
                    </div>

                    <div class="cont">

                        <div class="menu" data-user-id="<?php echo $review['user_id']; ?>" data-review-id="<?php echo $review['review_id']; ?>">
                            <button class="menu-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <div class="items" style="display: none;">
                                <a href="#" class="report-btn">Report User</a>
                            </div>
                        </div>

                        <div class="review-rating">
                            <?php
                            for ($j = 0; $j < $review['rating']; $j++) {
                            ?>
                                <i class="fas fa-star"></i>
                            <?php
                            }
                            ?>
                        </div>
                    </div>


                </div>

                <p class="review-description">
                    <?php echo $review['description']; ?>
                </p>

            </div>

            </div>
        <?php
        }
        ?>

    </section>

    <div id="report-modal" class="modal">
        <div class="modal-content">

            <h4>Please tell us why you're reporting this user:</h4>

            <form class="report-form" method="post" action="report_user.php" name="report-form">
                <label><input type="radio" name="reportReason" value="spam" required> Spam or Scam</label>
                <label><input type="radio" name="reportReason" value="hate-speech"> Hate Speech or Symbols</label>
                <label><input type="radio" name="reportReason" value="harassment"> Harassment or Bullying</label>
                <label><input type="radio" name="reportReason" value="violence"> Violent or Graphic Content</label>
                <label><input type="radio" name="reportReason" value="misinformation"> Misinformation</label>
                <label><input type="radio" name="reportReason" value="child-safety"> Child Safety Concern</label>
                <label><input type="radio" name="reportReason" value="impersonation"> Impersonation</label>
                <label><input type="radio" name="reportReason" value="other"> Other</label>

                <input type="hidden" name="user" id="reported-user-id" value="">
                <input type="hidden" name="review" id="reported-review-id" value="">
                <br>
                <button class="submit-report" name="submit">Submit</button>
            </form>
        </div>
    </div>

    <?php
    include("footer.html");
    ?>

    <script src="js/main.js"></script>

</body>

</html>