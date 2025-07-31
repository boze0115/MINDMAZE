<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'mindmaze');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the teacher is not logged in
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
    <link rel="stylesheet" href="../CSS/quiz.css">
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
    <div class="quiz-button">
        <?php
        // Query to retrieve quiz codes
        $sql = "SELECT DISTINCT Quiz_Code,Quiz_Title FROM QUIZ";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $quiz_code = $row['Quiz_Code'];
                $quiz_title = $row['Quiz_Title'];
                echo '<button><a href="../PHP/diplayquiz.php?quiz_code=' . $quiz_code . '">'.$quiz_title.'(' . $quiz_code . ')</a></button>';
            }
        } else {
            echo "No quizzes available";
        }
        ?>
       <button id="addQuiz">+</button>
    </div>

    <div id="quizContainer"></div>

    <script>
        document.getElementById("addQuiz").addEventListener("click", function() {
            // Redirect to create.php to create a new quiz
            window.location.href = '../PHP/create.php';
        });
    </script>


    <script>
        document.getElementById("addQuiz").addEventListener("click", function() {
            var quizContainer = document.getElementById("quizContainer");
            var newQuizBox = document.createElement("div");
            newQuizBox.className = "quiz-box";
            newQuizBox.innerHTML = '<h3>New Quiz</h3>';
            quizContainer.appendChild(newQuizBox);
            // You can add form elements or other content for the new quiz box here
            // For example, you can use AJAX to fetch and display the questions inside this box
        });
    </script>

</body>
</html>
