document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add');
    if (addButton) {
        addButton.addEventListener('click', function() {
            const form = document.getElementById('movieForm');
            form.action = 'add-movie.php';
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const updateButton = document.getElementById('update');
    if (updateButton) {
        updateButton.addEventListener('click', function() {
            const form = document.getElementById('movieForm');
            form.action = 'update-movie.php';
        });
    }
});

document.querySelectorAll('.updateLink').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        const itemId = this.getAttribute('data-id');

        fetch('get-item.php?id=' + encodeURIComponent(itemId))
            .then(response => response.json())
            .then(data => {
                document.getElementById('movie_id').value = data.id;
                document.getElementById('title').value = data.name;
                document.getElementById('cover').value.image = data.image;
                document.getElementById('trailer').value = data.trailer;
                document.getElementById('year').value = data.year;
                document.getElementById('duration').value = data.duration;
                document.getElementById('description').value = data.description;
            })
            .catch(error => {
                alert("Error loading item data: " + error.message);
            });
    });
});



function mySearchFunction() {
    var input = document.getElementById("search");
    var filter = input.value.toLowerCase();
    var rows = document.querySelectorAll(".movie-row");

    rows.forEach(function (row) {
        var id = row.cells[0].textContent.toLowerCase();
        var title = row.cells[1].textContent.toLowerCase();

        if (id.indexOf(filter) > -1 || title.indexOf(filter) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function searchAllFunction() {
    var input = document.getElementById("search-all");
    var filter = input.value.toLowerCase();
    var rows = document.querySelectorAll(".movie-row");

    rows.forEach(function (row) {
        var id = row.cells[0].textContent.toLowerCase();
        var title = row.cells[1].textContent.toLowerCase();
        var year = row.cells[4].textContent.toLowerCase();

        if (id.indexOf(filter) > -1 || title.indexOf(filter) > -1 || year.indexOf(filter) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function searchReports() {
    var input = document.getElementById("search-reports");
    var filter = input.value.toLowerCase();
    var rows = document.querySelectorAll(".movie-row");

    rows.forEach(function (row) {
        var id = row.cells[1].textContent.toLowerCase();
        var reason = row.cells[2].textContent.toLowerCase();
        var user = row.cells[6].textContent.toLowerCase();

        if (id.includes(filter) || reason.includes(filter) || user.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function getIndex(x) {
    const index = x.rowIndex;
    document.getElementById('index').textContent = "Table index: " + index;

    console.log(index);
}

function highlightRow(radio) {
    // Remove 'selected-row' class from all rows
    document.querySelectorAll("table tr").forEach(row => {
        row.classList.remove("selected-row");
    });

    // Add 'selected-row' class to the clicked row
    const row = radio.closest("tr");
    row.classList.add("selected-row");

    // Get the data from the row cells
    const rowData = Array.from(row.cells).map(cell => cell.textContent.trim());

    document.getElementById("report-id").value = rowData[1];
    document.getElementById("review-id").value = rowData[3];
    document.getElementById("user-id").value = rowData[5];

    console.log("Report ID: ", rowData[1]);
    console.log("Review ID: ", rowData[3]);
    console.log("User ID: ", rowData[5]);
}

document.getElementById('deleteReviewButton').addEventListener('click', function () {

    if (confirm("Are you sure you want to delete this review?")) {

        const reportId = document.getElementById('review-id').value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete-abusive-review.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        const data = "review_id=" + encodeURIComponent(reportId);
        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            } else {
                alert("Error: " + xhr.status);
            }
        };
    }
});

document.getElementById('deleteReportButton').addEventListener('click', function () {

    if (confirm("Are you sure you want to delete this report?")) {

        const reportId = document.getElementById('report-id').value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete-report.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        const data = "report_id=" + encodeURIComponent(reportId);
        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            } else {
                alert("Error: " + xhr.status);
            }
        };
    }
});

document.getElementById('suspendAccountButton').addEventListener('click', function () {

    if (confirm("Are you sure you want to suspend this account?")) {

        const userId = document.getElementById('user-id').value;
        const reviewId = document.getElementById('review-id').value;

        fetch('./suspend-user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'user_id=' + encodeURIComponent(userId)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return fetch('./delete-abusive-review.php', {           //therrasim skedarin php per te bere fshirjen e review-s
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'review_id=' + encodeURIComponent(reviewId)
            });
        })
        .then(response => response.text())
        .then(deleteResponse => {
            alert(deleteResponse);
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while processing your request.");
        });
    }
});

document.getElementById('deleteAccountButton').addEventListener('click', function () {

    if (confirm("Are you sure you want to delete this account?")) {

        const userId = document.getElementById('user-id').value;

        fetch('./delete-account.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'user_id=' + encodeURIComponent(userId)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.text();
        })
        .then(data => {
            alert(data);
        })
        .catch(error => {
            alert("Error: " + error.message);
        });
    }

});