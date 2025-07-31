
<?php
    session_start(); // Start the session
    // PHP code for handling form submission and database validation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include("../php/conn.php");

        $code = $_POST["code"];
        

        
        $sql = "SELECT * FROM QUIZ WHERE Quiz_Code = '$code' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User authenticated, redirect to main page
            $_SESSION['code'] = $code; // Store code in session for future use
            header("Location:../php/quizattempt.php");
            exit();
        } else {
            // Invalid credentials, show error message
            echo "<script>alert('Invalid quiz code. Please try again.');</script>";
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/codepage.css">
</head>
<body>
    <header class="container">
        <img class="logo" src="../image/newlogo.png" alt="mindmaze">
        <nav >
            <a href="../PHP/mainpage.php">HOME</a>
            <a href="../PHP/sprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="code">
        <h1>ENTER QUIZ CODE</h1>
        <input type="text" name="code" class="box" placeholder="Enter Code" required>
        <input type="submit" value="Join" id="submit">
    </form>
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../PHP/loginpage.php'; 
            }
        }
    </script>
     
</body>
</html>