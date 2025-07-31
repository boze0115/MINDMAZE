<?php
    include ("conn.php");

    // Start the session
    session_start();

    // Check if username is set in session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        // Define SQL query
        $sql = "SELECT * FROM teacher WHERE Teach_Name='$username'";
        
        // Execute SQL query
        $result = $conn->query($sql);

        // Check if result is not empty
        if ($result->num_rows > 0) {
            // Fetch data from the database
            while ($row = $result->fetch_assoc()) {
                $name = $row["Name"];
                $email = $row["EmailAddress"];
                $password = $row["Password"];
                $phone_number = $row["PhoneNum"];
            }
        } else {
            echo "No data found";
        }
    } else {
        echo "Session username is not set";
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve submitted data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        
        // Update user data in the database
        $sql = "UPDATE `teacher` SET `Name` = '$name', `Password` = '$password', `EmailAddress` = '$email', `PhoneNum` = '$phone_number' WHERE `Teach_Name` = '$username'";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect back to the profile page with success message
            header("Location: tprofile-edit.php?success=1");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/page2.css">
    <script>
        function enableEdit() {
            var inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach(function(input) {
                input.removeAttribute('readonly');
            });
        }
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../PHP/loginpage.php' 
            }
        }
        function saveConfirmation() {
            var confirmation = confirm('Are you sure you want to save changes?');
            return confirmation;
        }

    </script>
</head>
<body>
    <header class="container">
        <img class="logo" src="../image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/tmain.php">HOME</a>
            <a href="../PHP/tprofile.php">VIEW PROFILE</a>
            <a href="#"  onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header> 
    <div class="content">
        <div class="left">
            <h3>USERNAME</h3>
            <h1><?php echo $username ?></h1>
        
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return saveConfirmation();">
            <div class="right">
            <h1>NAME</h1>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required >
                <h1>EMAIL ADDRESS</h1>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <h1>PASSWORD</h1>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
                <h1>PHONE NUMBER</h1>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" required>
                <input type="hidden" name="username" value="<?php echo $username; ?>" >
            </div>
            <div class="button">
                <center><button type="button" onclick="history.back()" class="back">Back to Previous Page</button>
                <button type="submit">Save</button></center>
            </div>
        </form>
    </div>
</body>
</html>

