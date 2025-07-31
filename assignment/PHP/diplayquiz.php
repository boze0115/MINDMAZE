<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'mindmaze');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../PHP/loginpage.php');
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="../CSS/displayquiz.css">
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../php/loginpage.php' 
            }
        }
    </script>
</head>
<body>
    <header class="container">
        <img class="logo" src="../Image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/tmain.php">HOME</a>
            <a href="../PHP/tprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
    <div class="quiz-questions">
        <?php
        // Check if the quiz code is provided in the URL
        if(isset($_GET['quiz_code'])) {
            $quiz_code = $_GET['quiz_code'];

            // Query to retrieve quiz questions and answers based on the provided quiz code
            $sql = "SELECT * FROM quiz_question WHERE Quiz_Code = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $quiz_code); // assuming the quiz_code is a string type
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $questionNumber = 1; // Initialize question number counter
                while($row = $result->fetch_assoc()) {
                    echo '<div class="question">';
                    echo '<p>' . $questionNumber . '. ' . $row['Question'] . '</p>';
                    echo '<ul>';
                    echo '<li>' . $row['Option1'] . '</li>';
                    echo '<li>' . $row['Option2'] . '</li>';
                    echo '<li>' . $row['Option3'] . '</li>';
                    echo '<li>' . $row['Option4'] . '</li>';
                    echo '</ul>';
                    echo '<p>Answer: ' . $row['Answer'] . '</p>';
                    echo '</div>';
                    $questionNumber++; // Increment question number counter
                }
            } else {
                echo "No questions available for this quiz";
            }
            $stmt->close();
        } else {
            echo "No quiz code provided";
        }
        ?>
    </div>

    <a class="back-button" href="../PHP/tquiz.php">Back</a>


</body>
</html>
