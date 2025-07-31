<?php
session_start(); // Start the PHP session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../php/loginpage.php");
    exit(); // Stop further execution
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/mainpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            <a href="../php/mainpage.php">HOME</a>
            <a href="../PHP/sprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
 
    <div class="container">
        <div class="intro">
            <h1 class="intro-title"><i>WELCOME</i></h1>
            <h1 class="username"><u><?php echo $_SESSION['username']; ?></u></h1>
            <input type="button" value =" Main Menu" class="mainmenu">
            <br>
        </div>
    </div>
    <section class="menu-section">
        <div class="menu">
            <div>
                <a href="../php/codepage.php">   
                    <span class="material-symbols-outlined" >apps</span>
                    <h3>Code</h3>
                </a>
            </div>
        </div>
    </section>
</body>
</html>


