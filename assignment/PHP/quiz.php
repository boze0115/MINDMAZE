<?php
$conn = new mysqli('localhost', 'root', '', 'mindmaze');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="../CSS/quiz.css">
</head>
<body>
    <header class="container">
        <img class="logo" src="../Image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/tmain.php">HOME</a>
            <a href="../PHP/tprofile.php">VIEW PROFILE</a>
            <a href="#">LOGOUT</a>
        </nav>
    </header>
    <div class="quiz-button">
        <button>
            <a href="#">Quiz 1</a>
        </button>
        <button>
            <a href="#">Quiz 2</a>
        </button>
        <button>
            <a href="#">Quiz 3</a>
        </button>

        <button>
            <a href="#">Quiz 4</a>
        </button>
        <button>
            <a href="#">Quiz 5</a>
        </button>

        <button>
            <a href="../PHP/create.php">+</a>
        </button>

        
    </div>
</body>
</html>
