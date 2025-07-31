<?php
    session_start(); // Start the session
    // PHP code for handling form submission and database validation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include("../php/conn.php");

        $Username = $_POST["username"];
        $Password = $_POST["password"];

        // Validate username and password against the database
        $sql_student = "SELECT * FROM STUDENT WHERE User_Name = '$Username' AND Password = '$Password'";
        $sql_teacher = "SELECT * FROM TEACHER WHERE teach_name = '$Username' AND Password = '$Password'";
        $sql_admin = "SELECT * FROM ADMIN WHERE Admin_Name = '$Username' AND Password = '$Password'";

        $result_student = $conn->query($sql_student);
        $result_teacher = $conn->query($sql_teacher);
        $result_admin = $conn->query($sql_admin);

        if ($result_student->num_rows > 0) {
            // Student authenticated
            $_SESSION['username'] = $Username; // Store username in session for future use
            header("Location:../PHP/mainpage.php"); // Redirect to student page
            exit();
        } elseif ($result_teacher->num_rows > 0) {
            // Teacher authenticated
            $_SESSION['username'] = $Username; // Store username in session for future use
            header("Location:../PHP/tmain.php"); // Redirect to teacher page
            exit();
        } elseif ($result_admin->num_rows > 0) {
            // Admin authenticated
            $_SESSION['username'] = $Username; // Store username in session for future use
            header("Location:../PHP/admin.php"); // Redirect to admin page
            exit();
        } else {
            // Invalid credentials
            echo "<script>alert('Invalid username or password');</script>";
        }

        $conn->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../CSS/loginpage.css">
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form">
            <h2>Sign In to your account</h2>
            <input type="text" name="username" class="box" placeholder="Enter Username" required>
            <input type="password" name="password" class="box" placeholder="Enter Password" required>
            <input type="submit" value="Sign In" id="submit" >
            <h3>OR</h3>
            <a href="../php/studentsignuppage.php">Sign Up</a>
        </form>
        <div class="side">
            <img src="../image/logo.png" alt="" class="">
        </div>
    </div>  
</body>
</html>
