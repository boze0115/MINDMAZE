<?php
include("conn.php");
session_start(); // Start the PHP session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../php/loginpage.php");
    exit(); // Stop further execution
}
$sql = "SELECT COUNT(*) AS num_rows FROM quiz";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the result row as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Retrieve the number of rows
    $numRows = $row['num_rows'];

    // Free the result set
    mysqli_free_result($result);
} else {

    $numRows = "Error: " . mysqli_error($conn);
}
$sqlMedianScore = "SELECT Final_Score FROM student_result ORDER BY Final_Score ASC"; 
$resultMedianScore = mysqli_query($conn, $sqlMedianScore);

// Check if the query for fetching scores was successful
if ($resultMedianScore) {
    $scores = array();
    // Fetch scores and store them in an array
    while ($rowScore = mysqli_fetch_assoc($resultMedianScore)) {
        $scores[] = $rowScore['Final_Score'];
    }
    
    // Calculate the median score
    $countScores = count($scores);
    $medianIndex = floor($countScores / 2);
    if ($countScores % 2 == 0) {
        // If the number of scores is even, average the middle two scores
        $medianScore = ($scores[$medianIndex - 1] + $scores[$medianIndex]) / 2;
    } else {
        // If the number of scores is odd, use the middle score
        $medianScore = $scores[$medianIndex];
    }
} else {
    $medianScore = "Error: " . mysqli_error($conn);
}
$sqlAverageScore = "SELECT AVG(Final_Score) AS average_score FROM student_result"; 
$resultAverageScore = mysqli_query($conn, $sqlAverageScore);

// Check if the query for fetching the average score was successful
if ($resultAverageScore) {
    // Fetch the result row as an associative array
    $rowAverageScore = mysqli_fetch_assoc($resultAverageScore);
    
    // Retrieve the average score
    $averageScore = $rowAverageScore['average_score'];

    // Free the result set
    mysqli_free_result($resultAverageScore);
} else {
    // Handle query errors
    $averageScore = "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../CSS/page.css">
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../php/loginpage.php' 
            }
        }
        function scrollToSection(sectionId) {
            var section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
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

    <div class="intro-container">
    <br><br>
        <img src="../image/computer.jpg" class="admin" alt="Computer"></img>
            <div class="welcome">
                
                <h1 class="intro-title"><i>WELCOME</i></h1>
                <h1 class="username"><u><?php echo $_SESSION['username']; ?></u></h1>
                <p>A good education can change anyone</p>
                <button class="dashboard-btn" onclick="scrollToSection('dashboard')">Dashboard</button>
                <button class="menu-btn" onclick="scrollToSection('main-menu')">Main Menu</button>
            </div>
    </div>
    <h1 class=title1>Dashboard</h1>
    <div class="dashboard">
        <main class="left">
            <div class="box">
                <div class="symbol">
                    <span class="material-symbols-outlined">trending_up</span>
                </div>
                <div class="trending"></div>
                <h2>Number of quiz added</h2>
                <h1><?php echo $numRows;?></h1>
            </div>
            <div class="box">
                <div class="symbol">
                    <span class="material-symbols-outlined"><span class="material-symbols-outlined">query_stats
</span></span>
                </div>
                <div class="score"></div>
                <h2>Median of score</h2>
                <h1><?php echo $medianScore; ?></h1>
            </div>
            <div class="box">
                <div class="symbol">
                    <span class="material-symbols-outlined"><span class="material-symbols-outlined">bar_chart
</span></span>
                </div>
                <div class="score"></div>
                <h2>Average of score</h2>
                <h1><?php echo $averageScore; ?></h1>
            </div>
        </main>


    </div>
    <h1 class=title1>Main Menu</h1>
    <section id="main-menu" class="menu-section">
        <br><br>
        <div class="menu">
            <div>
                <a href="../PHP/quizresultreview.php">
                    <span class="material-symbols-outlined">lab_profile</span>
                    <h3>Quiz Result Overview</h3>
                </a>
            </div>
            <div>
                <a href="../PHP/leaderboard.php">
                    <span class="material-symbols-outlined">leaderboard</span>
                    <h3>Manage leaderboard</h3>
                </a>
            </div>
            <div>
                <a href="../PHP/deactivate.php">
                    <span class="material-symbols-outlined">account_box</span>
                    <h3>Deactivate account</h3>
                </a>
            </div>
        </div>
        <br><br>
    </section>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</body>
</html>