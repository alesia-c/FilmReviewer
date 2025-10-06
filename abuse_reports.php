<?php
session_start();
include 'connect.php';

ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Abuse</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/reports-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        .selected-row {
            background-color: #242629;
        }
    </style>

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

    <section class="reports">

        <div class="table-wrapper">

            <input type="text" id="search-reports" class="search" oninput="searchReports()" placeholder="Search for abuse reports">

            <table class="table" id="table">
                <tr id="first-tr">
                    <th></th>
                    <th>ID</th>
                    <th>Reason</th>
                    <th class="hide-col">Review ID</th>
                    <th>Content</th>
                    <th class="hide-col">User ID</th>
                    <th>Reported User</th>
                </tr>

                <tbody>
                    <?php
                    $query = "SELECT * FROM abuse_reports";
                    $result = mysqli_query($db_connection, $query) or die("Error executing query");
                    $n = mysqli_num_rows($result);

                    for ($i = 0; $i < $n; $i++) {
                        $row = mysqli_fetch_array($result);
                    ?>
                        <!-- eshte pedoruru ky emer klase qe te mos shkruaj te njejtin css ne dy skedare -->
                        <tr class="movie-row" onclick="getIndex(this)">
                            <td><input type="radio" class="cyberpunk-checkbox" name="select" onclick="highlightRow(this)"></td>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['reason']); ?></td>
                            <td class="hide-col"><?php echo htmlspecialchars($row['review_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="hide-col"><?php echo htmlspecialchars($row['reported_user_id']); ?></td>
                            <td class="user">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" class="profile-pic" alt="Profile Picture">
                                <?php echo htmlspecialchars($row['reported_user']); ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </section>

    <section>

        <div class="action-buttons">
            <button id="deleteReviewButton">Delete Review</button>
            <button id="deleteReportButton">Delete Report</button>
            <button id="suspendAccountButton">Suspend Account</button>
            <button id="deleteAccountButton">Delete Account</button>
        </div>

            <input type="hidden" value="" id="report-id">
            <input type="hidden" value="" id="review-id">
            <input type="hidden" value="" id="user-id">
        
    </section>

    <br>
    <p id="index">Table index: </p>

    <script src="js/admin.js"></script>
</body>

</html>