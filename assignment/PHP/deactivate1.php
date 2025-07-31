<?php
include("conn.php");

if(isset($_POST['deactivate'])) {
    $student_id = $_POST['student_id'];

    $sql = "DELETE FROM student WHERE User_Name = '$student_id'";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Account deactivated successfully";
        header("Location: ".$_SERVER['HTTP_REFERER']."?success_message=".urlencode($success_message));
        exit;
    } else {
        echo "Error deactivating account: " . $conn->error;
    }
}

$conn->close();
?>
