<?php
// Include database connection file
include("conn.php");

$degree = 0;

// Check if the title parameter is set in the URL
if(isset($_GET['title'])) {
    // Retrieve the quiz title from the URL
    $quiz_title = $_GET['title'];

    // Query to get the quiz code based on the quiz title
    $query = "SELECT Quiz_Code FROM quiz WHERE Quiz_Title = '$quiz_title'";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        // Fetch the quiz code
        $row = $result->fetch_assoc();
        $quiz_code = $row['Quiz_Code'];

        // Query to get student results based on the quiz code
        $result_query = "SELECT * FROM student_result WHERE Quiz_Code = '$quiz_code'";
        $result_result = $conn->query($result_query);

        // Calculate average score
        $total_scores = 0;
        $total_students = $result_result->num_rows;

        while($row_result = $result_result->fetch_assoc()) {
            $total_scores += $row_result['Final_Score'];
        }

        $average_score = $total_students > 0 ? $total_scores / $total_students : 0;

        $degree = $average_score * 3.6;
        // Output the quiz title and average score
        echo "<h3>Quiz Title: $quiz_title</h3>";
    } else {
        echo "<h3>No quiz found with the given title.</h3>";
    }
} else {
    echo "<h3>Quiz title parameter not set.</h3>";
}

// Query to count the number of participants based on Quiz_Code existence
if(isset($quiz_code)) {
    $participants_query = "SELECT COUNT(DISTINCT User_Name) AS num_participants FROM student_result WHERE Quiz_Code = '$quiz_code'";
    $participants_result = $conn->query($participants_query);

    if($participants_result->num_rows > 0) {
        // Fetch the number of participants
        $participants_row = $participants_result->fetch_assoc();
        $num_participants = $participants_row['num_participants'];
    } else {
        $num_participants = 0;
    }

    // Output the number of participants
} else {
    echo "<h3>No quiz code available.</h3>";
}

// Query to count the number of questions
$question_query = "SELECT COUNT(*) AS num_questions FROM quiz_question WHERE Quiz_Code = '$quiz_code'";
$question_result = $conn->query($question_query);

if($question_result->num_rows > 0) {
    // Fetch the number of questions
    $question_row = $question_result->fetch_assoc();
    $num_questions = $question_row['num_questions'];
} else {
    $num_questions = 0;
}

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
    font-family: "Poppins", sans-serif;
}
body {
    margin: 0;
    background-color: white;
    overflow: hidden;
}
.container{
    width:100%;
}
header {
    display:flex;
    justify-content: space-between;
    align-items: center;
    background-color: #9ED9FB;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    letter-spacing: 5px;
    font-weight: bold;
    position:fixed;
    width:100%;
    top:0;
    left:0;
    right:0;
}
header.container img.logo{
    width: 25%;
    max-width: 100px;
    height: 25%;
    max-height: 150px;
    margin-left:20px;
    margin-right:0;
    cursor: pointer;
    position: relative;
    text-align: center;
    transition: all 0.2s;
}
header.container img{
    padding:0;
    margin:0;
}
 
header.container nav{
    display:flex;
    flex-wrap: wrap;
}
header.container nav a {
    margin-right: 20px;
    text-decoration: none;
    color: white;
    padding:10px 30px;
    font-size: 1.5vw;
}

.logo:hover{
    background:pink;
}

.container.pagetitle h3{
    font-size: 2em;
    padding:80px auto;
    margin: 20px auto;
    margin-top: 50px;
    background: linear-gradient(to right, #9ED9FB, transparent 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    letter-spacing: 15px;
    font-weight: 10px;
    text-align: center;
    width: 70vw;
    z-index: 2;
    position: relative;
    box-shadow: 0 2px 8px lightgrey;
}

.dropdown{
    text-align: center;
    display: flex;
    position: relative;
    justify-content: center;
    left: 38%;
    top: 15px;
    padding-top: 10px;
}
#myInput{
    width: 300px;
    height: 30px;
    font-size: 15px;
    text-align: center;
    margin:0 auto;
}
#myDropdown {
    position: absolute;
    background-color: #f6f6f6;
    min-width: 230px;
    overflow: auto;
    border: 1px solid #ddd;
    z-index: 1;
    display: none;
    align-items: center;
    text-align: center;
    width:300px;
    font-size: 20px;

}

#myDropdown a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

#myDropdown a:hover {
    background-color: #ddd;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.content{
    display: grid;
    grid-template-columns:50% 50%;
    width: 80%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin:30px auto;
    height: 65vh;
}

.left, .right{
    width: 100%;
    

}
.left {
    box-sizing: border-box;
    margin: 0;
    border-radius: 10px;
    border: 2px solid black;
    background: whitesmoke;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Increased shadow intensity */
    transition: box-shadow 0.3s ease;
}

.left:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* More intense shadow on hover */
}

.right{
    box-sizing: border-box;
    margin:40px 0;
    padding-left:30px;
}

.circular-progress{
    position: relative;
    height: 250px;
    width: 250px;
    border-radius: 50%;
    background: conic-gradient(#9ED9FB <?php echo $average_score; ?>deg, #ededed 0deg);
    text-align: left;
    margin-left:30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 100px;
}

.progress-value{
    display: absolute;
    font-size: 3em;
    color: white;
    text-shadow:2px black;
}

.left h1{
    text-align: right;
    margin-top:-200px;
    margin-bottom: 175px;
    font-size: 3em;
    padding: 6px;
    display: absolute;
    margin-right: 10px;
    color: transparent;
    -webkit-text-stroke: 2px #000;
    letter-spacing: 3px;
}
.right .details{
    border: 1px solid black;
    margin:30px 5px;
    padding:20px;

}
.details h1{
    color: transparent;
    -webkit-text-stroke: 2px #000;
    letter-spacing: 2px;
    font-size: 1.7em;
}
.details {
    border: 1px solid black;
    margin: 10px 5px;
    padding: 20px;
    background-color: #007bff;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}
.details:hover {
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}
.details h1 {
    color: white;
    -webkit-text-stroke: 1.2px;
    letter-spacing: 2px;
    font-size: 1.7em;
    
}
.back-button {
    color: #fff;
    text-decoration: none;
    background-color: #007bff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #0056b3;
}

.back-button ion-icon {
    margin-right: 5px;
}


    </style>
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
            <a href="../PHP/admin.php">HOME</a>
            <a href="../PHP/aprofile.php">VIEW PROFILE</a>
            <a href="#" onclick="logoutConfirmation();">LOGOUT</a>
        </nav>
    </header>
    <div class="container pagetitle">
        <?php
            // Check if the title parameter is set in the URL
            if(isset($_GET['title'])) {
                // Retrieve the quiz title from the URL
                $quiz_title = $_GET['title'];

                // Output the quiz title
                echo "<h3>Quiz Title: $quiz_title</h3>";
            } else {
                echo "<h3>Quiz title parameter not set.</h3>";
            }
        ?>
    </div>
    <div class="content">
        <div class="left">
        <div class="circular-progress" style="background: conic-gradient(#9ED9FB <?php echo $degree; ?>deg, #ededed 0deg);">
            <span class="progress-value"><?php echo $average_score; ?>%</span>
        </div>
            <h1>AVERAGE</h1>
            <h1>SCORE</h1>
        </div>
        <div class="right">
            <div class="details">
                <h1>TOTAL NUMBER OF PARTICIPANT</h1>
                <h2><?php echo $num_participants?>students</h2>
            </div>
            <div class="details">
                <h1>TOTAL NUMBER OF QUESTION</h1>
                <h2><?php echo $num_questions;?>questions</h2>
            </div>
            <a href="#" onclick="history.back();" class="back-button">
                <ion-icon name="arrow-back"></ion-icon> Back to Previous Quiz
            </a>

        </div>
    </div>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</body>
</html>