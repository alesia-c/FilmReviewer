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

    <section id="all">

        <div>

            <input type="text" id="search-all" class="search" oninput="searchAllFunction()" placeholder="Search movie"> 

            <table class="all">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Cover</th>
                    <th>Trailer</th>
                    <th>Release Year</th>
                    <th>Duration</th>
                    <th>Description</th>
                </tr>
                <tbody>
                    <?php
                    $query = "SELECT * FROM movies";
                    $result = mysqli_query($db_connection, $query) or die("Error executing query");
                    $n = mysqli_num_rows($result);
                    for ($i = 0; $i < $n; $i++) {
                        $row = mysqli_fetch_array($result);
                    ?>
                        <tr class="movie-row">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>"></td>
                            <td><?php echo $row['trailer']; ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td><?php echo $row['duration']; ?></td>
                            <td id="plot"><?php echo $row['description']; ?></td>
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