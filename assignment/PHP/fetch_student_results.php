<?php
include("conn.php");

// Retrieve the quiz title from the GET parameter
$quizTitle = $_GET['quizTitle'];

// Query the database to retrieve the quiz code based on the quiz title
$sql_quiz = "SELECT Quiz_Code FROM quiz WHERE Quiz_Title = '$quizTitle'";
$result_quiz = $conn->query($sql_quiz);

if ($result_quiz->num_rows > 0) {
    // Fetch the quiz code
    $row_quiz = $result_quiz->fetch_assoc();
    $quizCode = $row_quiz['Quiz_Code'];

    // Query the database for student results based on the quiz code, ordered by Final_Score in descending order
    $sql_results = "SELECT * FROM student_result WHERE Quiz_Code = '$quizCode' ORDER BY Final_Score DESC";
    $result_results = $conn->query($sql_results);

    // Initialize rank counter
    $rank = 1;

    // Output the student results in HTML format with ranks
    if ($result_results->num_rows > 0) {
        while ($row = $result_results->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$rank}</td>"; // Output the rank
            echo "<td>{$row['User_Name']}</td>";
            echo "<td>{$row['Final_Score']}</td>";
            echo "</tr>";
            $rank++; // Increment the rank counter
        }
    } else {
        echo "<tr><td colspan='3'>No results found</td></tr>";
    }
} else {
    echo "<tr><td colspan='3'>Quiz not found</td></tr>";
}

$conn->close();
?>
