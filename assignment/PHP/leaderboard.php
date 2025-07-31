<?php
include("conn.php");

// Fetch quiz titles from the database
$sql = "SELECT Quiz_Code, Quiz_Title FROM quiz";
$result = $conn->query($sql);

$quizTitles = array(); // Initialize an array to store quiz titles

if ($result->num_rows > 0) {
    // Output data of each  
    while ($row = $result->fetch_assoc()) {
        // Add each quiz title to the array
        $quizTitles[] = array("Quiz_Code" => $row["Quiz_Code"], "Quiz_Title" => $row["Quiz_Title"]);
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/page3.css">
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../php/loginpage.php';
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            var quizSelect = document.getElementById("quizSelect");

            quizSelect.addEventListener("change", function() {
                var quizTitle = this.value;
                
                // Make an AJAX request to fetch_student_results.php
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("studentResultsBody").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "fetch_student_results.php?quizTitle=" + encodeURIComponent(quizTitle), true);
                xhttp.send();
            });
        });
    </script>
</head>
<body>
<header class="container">
    <img class="logo" src="../image/newlogo.png" alt="mindmaze">
    <nav>
        <a href="../PHP/admin.php">HOME</a>
        <a href="../PHP/aprofile.php">VIEW PROFILE</a>
        <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
    </nav>
</header>
<div class="container pagetitle">
    <img src="../image/trophy.png">
    <h3>LEADERBOARD</h3>
</div>
<form id="quizForm" method="get" action="fetch_student_results.php">
    <div class="dropdown">
        <label for="quizSelect">Choose a quiz:</label>
        <select id="quizSelect" name="quizTitle" required>
            <option value="">Select a quiz</option>
            <?php
            foreach ($quizTitles as $quiz) {
                echo "<option value='" . $quiz["Quiz_Title"] . "'>" . $quiz["Quiz_Title"] . "</option>";
            }
            ?>
        </select>
    </div>
</form>

<table class="content-table" id="studentResultsTable">
    <thead>
    <tr>
        <th>RANK</th>
        <th>NAME</th>
        <th>SCORE</th>
    </tr>
    </thead>
    <tbody id="studentResultsBody">
    <tr><td colspan="3">Please select a quiz.</td></tr>
    </tbody>
</table>
</body>
</html>
