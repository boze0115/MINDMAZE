<?php
session_start();
include("conn.php");

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];


    $sql = "SELECT Teach_Name,Name,EmailAddress,Password,PhoneNum FROM TEACHER WHERE Teach_Name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["Name"];
        $email = $row["EmailAddress"];
        $password = $row["Password"];
        $phone = $row["PhoneNum"];
        
    }
    
} else {
    header("location:../PHP/loginpage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/viewprofile.css">
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
        <img class="logo" src="../image/newlogo.png" alt="mindmaze">
        <nav>
            <a href="../PHP/tmain.php">HOME</a>
            <a href="../PHP/tprofile.php">VIEW PROFILE</a>
            <a href="#" onclick='logoutConfirmation();'>LOGOUT</a>
        </nav>
    </header>
    <div class="content">
        <div class="left">
            <h3>USERNAME</h3>
            <h1><?php echo $username; ?></h1>
            <p>Do you want to change your profile?</p>
            <a href = "../PHP/tupdate.php">
            <button>YES</button>
            </a>
           
           
            
        </div>
        <form method="post">
            <div class="right">
                <h1>NAME</h1>
                <p><?php echo $name; ?></p>
                <h1>EMAIL ADDRESS</h1>
                <p><?php echo $email; ?></p>
                <h1>PASSWORD</h1>
                <p><?php echo $password; ?></p>
                <h1>PHONE NUMBER</h1>
                <p><?php echo $phone; ?></p>
            </div>
    </div>
</body>
</html>