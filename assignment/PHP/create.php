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

// Retrieve the logged-in teacher's username from the session
$teacherUsername = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form is submitted
    if (isset($_POST['code']) && isset($_POST['quiz_title'])) {
        // Retrieve the form data
        $code = $_POST['code'];
        $quizTitle = $_POST['quiz_title'];

        // Validate the code
        if (empty($code)) {
            echo "Error: Quiz code cannot be empty";
            exit();
        }

        // Check if the code already exists in the database
        $check_query = "SELECT Quiz_Code FROM QUIZ WHERE Quiz_Code = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $code);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Alert notice if the code already exists
            echo "<script>alert('Quiz code already exists. Please choose a different one.'); window.location.href = '../PHP/create.php';</script>";
            $check_stmt->close();
            exit();
        }

        // Close the prepared statement for checking code existence
        $check_stmt->close();

        // Store the quiz code in a session variable
        $_SESSION['quiz_code'] = $code;

        // Prepare the SQL statement to insert data into the QUIZ table
        $sql = "INSERT INTO QUIZ (Quiz_Code, Quiz_Title, Teach_Name) VALUES (?, ?, ?)";

        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $code, $quizTitle, $teacherUsername);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to question.php with the quiz code as a query parameter
            header('Location: ../PHP/question.php');
            exit(); // Stop further execution
        } else {
            echo "Error inserting into QUIZ table: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="../CSS/create.css">
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
            <a href="#">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="code">
        <h1>Create QUIZ</h1>
        <input type="text" placeholder="Code" name="code" required>
        <input type="text" placeholder="Quiz Title" name="quiz_title" required>
        <input type="submit" value="Submit" id="submit">
    </form>
    
</body>
</html>
