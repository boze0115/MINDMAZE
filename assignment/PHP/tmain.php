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
    <title>Main</title>
    <link rel="stylesheet" href="../CSS/main.css">
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
            <a href="../PHP/tprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
 
    <div class="container">
        <div class="intro">
            <h1 class="intro-title"><i>WELCOME</i></h1>
            <h1 class="username"><u><?php echo $_SESSION['username']; ?></u></h1> <!-- Link User Name-->
            <input type="button" value =" Main Menu" class="mainmenu">
            <br>
        </div>
    </div>
    <section class="menu-section">
        <div class="menu">
           
            <div>
                <a href="../PHP/tquiz.php">
                    <span class="material-symbols-outlined" >apps</span>
                    <h3>Quiz</h3>
                </a>
            </div>
           
            <div>
                <a href="../PHP/tquizresultreview.php">
                    <span class="material-symbols-outlined" >apps</span>
                    <h3>Result</h3>
                </a>
            </div>
           
        </div>
    </section>
 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</body>



</html>