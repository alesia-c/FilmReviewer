<?php
session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div id="logo">
                <a href="index.php">Film<span>Reviewer</span></a>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="admin.php">Administrator</a></li>
                    <li><a href="all-movies-admin.php">All Movies</a></li>
                    <li><a href="abuse_reports.php">Manage Abuse Reports</a></li>
                    <li><a href="logout.php"><button>Log Out</button></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section>

        <div>
            <form method="post" id="movieForm" enctype="multipart/form-data">

                <input type="hidden" id="movie_id" name="movie_id">

                <label for="title">Movie Title</label>
                <input type="text" name="title" id="title" required>

                <label for="cover">Cover</label>
                <input type="file" name="cover" id="cover" required>

                <label for="trailer">Trailer</label>
                <input type="text" name="trailer" id="trailer" required>

                <label for="year">Release Year</label>
                <input type="text" name="year" id="year" inputmode="numeric" maxlength="4" required>

                <label for="duration">Duration</label>
                <input type="text" name="duration" id="duration" inputmode="numeric" maxlength="3" required>

                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>

                <button type="submit" name="add" class="btn" id="add">Add New Movie</button>
                <button type="submit" name="update" class="btn" id="update">Update Movie Info</button>
                <button name="clear" class="btn" id="clear">Clear Form</button>

            </form>
        </div>

        <div class="table-wrapper">

            <input type="text" id="search" class="search" oninput="mySearchFunction()" placeholder="Search movie">

            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Cover</th>
                    <th colspan="2">Actions</th>
                </tr>

                <tbody>
                    <?php
                    $query = "SELECT id, name, image FROM movies";
                    $result = mysqli_query($db_connection, $query) or die("Error executing query");
                    $n = mysqli_num_rows($result);
                    for ($i = 0; $i < $n; $i++) {
                        $row = mysqli_fetch_array($result);
                    ?>
                        <tr class="movie-row">
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="movie cover"></td>
                            <td class="actions">
                                <a href="delete-movie.php?id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                            <td class="actions">
                                <a href="get-item.php?id=<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" class="updateLink">Update</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script src="js/admin.js"></script>
</body>

</html>