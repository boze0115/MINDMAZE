<?php
    // Start the session to access session variables
    session_start();

    // Include the connection file
    include("conn.php");

    // Check if the session variable 'username' is set
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        // Assuming $result is obtained from a query executed in conn.php
        $result = $conn->query("SELECT * FROM admin WHERE Admin_Name = '$username'");
        
        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Assign retrieved values to variables
                $name = $row["Name"];
                $email = $row["EmailAddress"];
                $password = $row["Password"];
                $phone_number = $row["PhoneNum"];
            }
        } else {
            echo "No data found";
        }
    } else {
        // Redirect if session variable 'username' is not set
        header("Location: login.php");
        exit();
    }

    // Close the database connection
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
                window.location.href = '../php/loginpage.php' 
            }
        }
        
    </script>
</head>
<body>
    <header class="container">
        <img class="logo" src="../image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/admin.php">HOME</a>
            <a href="../PHP/aprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
    <div class="content">
        <div class="left">
            <h3>USERNAME</h3>
            <h1><?php echo $username ?></h1>
            <p>Do you want to change your profile?</p>
            <a href="../PHP/update.php">
            <button onclick="enableEdit()">YES</button>
             
            
            </a>
        </div>
        <form method="post" action="../PHP/update.php">
            <div class="right">
                <h1>NAME</h1>
                <p><?php echo $name;?></p>
                <h1>EMAIL ADDRESS</h1>
                <p><?php echo $email;?></p>
                <h1>PASSWORD</h1>
                <p><?php echo $password;?></p>
                <h1>PHONE NUMBER</h1>
                <p><?php echo $phone_number;?></p>
            </div>
        </form>
    </div>
</body>
</html>
