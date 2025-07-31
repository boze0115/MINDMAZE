<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'mindmaze');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Check if the quiz code is set in the session
if (!isset($_SESSION['quiz_code'])) {
    // Redirect to the create.php page if the quiz code is not set in the session
    header('Location: ../PHP/create.php');
    exit(); // Stop further execution
}

$code = $_SESSION['quiz_code']; // Corrected variable name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the question and options from the form
    $question = $_POST['question'];
    $options = $_POST['option'];
    $selected_answer = $_POST['answer']; // Retrieve the selected answer

    // Map the selected answer to the corresponding option (A/B/C/D)
    $answer = '';
    switch ($selected_answer) {
        case 'Option 1':
            $answer = 'A';
            break;
        case 'Option 2':
            $answer = 'B';
            break;
        case 'Option 3':
            $answer = 'C';
            break;
        case 'Option 4':
            $answer = 'D';
            break;
        default:
            // Handle default case
            break;
    }

    // Extract options from the nested array
    $option1 = $options[0][0];
    $option2 = $options[0][1];
    $option3 = $options[0][2];
    $option4 = $options[0][3];

    // Prepare and execute the SQL statement to insert into quiz_question
    $sql_insert_question = "INSERT INTO quiz_question (Quiz_Code, Question, Option1, Option2, Option3, Option4, Answer) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_question = $conn->prepare($sql_insert_question);
    $stmt_insert_question->bind_param("sssssss", $code, $question, $option1, $option2, $option3, $option4, $answer); // Corrected variable name
    
    if ($stmt_insert_question->execute()) {
        echo "Question added successfully!<br>";
    } else {
        echo "Error inserting into quiz_question table: " . $stmt_insert_question->error;
    }
    $stmt_insert_question->close();

    // Check if the "Submit" button is clicked
    if (isset($_POST['submit'])) {
        // Redirect to tquiz.php
        header('Location:../PHP/tquiz.php');
        exit(); // Stop further execution
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="../CSS/question.css">
</head>
<body>
    <header class="container">
        <img class="logo" src="../Image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/tmain.php">HOME</a>
            <a href="../PHP/tprofilr.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation()">LOGOUT</a>
        </nav>
    </header>
    <div class="container">
        <form id="questionForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="Question">
                <input type="text" class="questionInput" name="question" placeholder="Enter Question" required><br><br>
            </div>
            <div class="Options">
                <input type="text" class="optionInput" name="option[0][]" placeholder="Option A"  required>
                <input type="text" class="optionInput" name="option[0][]" placeholder="Option B" required>
                <input type="text" class="optionInput" name="option[0][]" placeholder="Option C" required>
                <input type="text" class="optionInput" name="option[0][]" placeholder="Option D" required>
            </div>
            <div class="Answer">
                <label for="answer">Correct Answer:</label>
                <select name="answer" id="answer" required>
                    <option value="Option 1">A</option>
                    <option value="Option 2">B</option>
                    <option value="Option 3">C</option>
                    <option value="Option 4">D</option>
                </select>
            </div>
            <br><br>
            <div class="buttons">
                <input type="submit" value="Next" name="next" onclick="submitForm('next')">
                <input type="submit" value="Submit" name="submit" onclick="submitForm('submit')">
            </div>
        </form>
    </div>

    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../PHP/loginpage.php'; // Replace 'logout.html' with the actual logout page
            }
        }

        function submitForm(buttonClicked) {
            if (buttonClicked === 'next') {
                // Submit the form
                document.getElementById('questionForm').submit();
            }
        }
    </script>
</body>
</html>