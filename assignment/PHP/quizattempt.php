<?php
session_start(); // Start the session

// Establish database connection
$con = mysqli_connect("localhost", "root", "", "mindmaze");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Check if the session variable 'code' is set, if not, redirect to the code page
if (!isset($_SESSION['code'])) {
    header("Location: ../PHP/codepage.php");
    exit();
}

// Check if the session variable 'username' is set, if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: ../PHP/loginpage.php");
    exit();
}

// Retrieve the quiz code from session
$code = $_SESSION['code'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize counters
    $numCorrect = 0;
    $numWrong = 0;
    $numQuestions = $_POST['qn'];

    // Iterate through each question
    for ($i = 1; $i <= $numQuestions; $i++) {
        // Retrieve correct answer from form data
        $questionId = $_POST['id' . $i];
        $selectedAnswer = $_POST['answer' . $i];

        // Retrieve correct answer from database
        $sql = "SELECT Answer FROM QUIZ_QUESTION WHERE Quiz_Code=? AND Question_ID=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $code, $questionId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $correctAnswer = $row['Answer'];

        // Check if selected answer matches the correct answer
        if ($selectedAnswer == $correctAnswer) {
            $numCorrect++; // Increment correct answer counter
        } else {
            $numWrong++; // Increment wrong answer counter
        }
    }

    // Calculate final score
    $finalResult = ($numCorrect / $numQuestions) * 100;

    // Insert or update results in the STUDENT_RESULT table
    $username = $_SESSION['username'];

    // Check if a record already exists for this quiz and user
    $sql = "SELECT * FROM STUDENT_RESULT WHERE Quiz_Code=? AND User_Name=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $code, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Update existing record
        $sql = "UPDATE STUDENT_RESULT SET Num_Of_Correct=?, Num_of_Wrong=?, Final_Score=? WHERE Quiz_Code=? AND User_Name=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iiiss", $numCorrect, $numWrong, $finalResult, $code, $username);
        mysqli_stmt_execute($stmt);
    } else {
        // Insert new record
        $sql = "INSERT INTO STUDENT_RESULT (Quiz_Code, User_Name, Num_Of_Correct, Num_of_Wrong, Final_Score) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssiid", $code, $username, $numCorrect, $numWrong, $finalResult);
        mysqli_stmt_execute($stmt);
    }

    // Redirect to a page displaying the result or any other page as needed
    header("Location: ../PHP/result.php?code=" . urlencode($code));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Interface</title>
    <link rel="stylesheet" href="../CSS/quizattempt.css">
</head>
<body>

<header class="container">
    <img class="logo" src="../image/newlogo.png" alt="mindmaze">
</header>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <?php
    // Retrieve quiz questions from the database
    $sql2 = "SELECT * FROM QUIZ_QUESTION WHERE Quiz_Code=?";
    $stmt2 = mysqli_prepare($con, $sql2);
    mysqli_stmt_bind_param($stmt2, "s", $code);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $x = 1;
    ?>
    <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
        <table  id="CreateQuestion">
            <input type="hidden" name="quizCode" value="<?php echo $code; ?>">
            <input type="hidden" name="id<?php echo $x; ?>" value="<?php echo $row2['Question_ID'] ?>">
            <div class="question"><?php echo $row2['Question'] ?></div>
            <div class="answer"> 
                <input type="radio" name="answer<?php echo $x; ?>" value="A" required>
                    <?php echo $row2['Option1'] ?>
                
                
                    <input type="radio" name="answer<?php echo $x; ?>" value="B" required>
                    <?php echo $row2['Option2'] ?>
                
                    <input type="radio" name="answer<?php echo $x; ?>" value="C" required>
                    <?php echo $row2['Option3'] ?>
                
                    <input type="radio" name="answer<?php echo $x; ?>" value="D" required>
                    <?php echo $row2['Option4'] ?>
            </div>
        </table>
        <?php $x++; ?>
    <?php } ?>
    <input type="hidden" name="qn" value="<?php echo ($x - 1) ?>">
    <input type="submit" value="Submit Quiz">
</form>

</body>
</html>
