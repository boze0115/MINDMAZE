<?php
session_start(); // Start the PHP session

// Include database connection
include("..\PHP\conn.php");

// Step 2: Query the database to retrieve the final score
$username = $_SESSION["username"]; // Specify the username
$quiz_code = $_GET["code"]; // Get the specific Quiz_Code from the URL parameter
$sql = "SELECT Final_Score FROM student_result WHERE User_Name = '$username' AND Quiz_Code = '$quiz_code'";
$result = $conn->query($sql);

// Error handling
if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Retrieve data
if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $final_score = $row["Final_Score"];
} else {
    // If no result found, set score to 0 or display an appropriate message
    $final_score = 0; // Or display a message like "Score not available"
}

$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>result interface</title>
    <link rel="stylesheet" href="../CSS/result.css">
</head>
<body>
    <header class="container">
        <img class="logo" src="../image/newlogo.png" alt="mindmaze">
    </header>
    <main>
        <div class="score">
            <h2><?php echo $username; ?>, Your Score</h2>
            <p><?php echo $final_score; ?></p>   
        </div>
        <form action="../PHP/mainpage.php">
            <button class="next-button">Finish</button>
        </form>
    </main>
</body>
</html>
