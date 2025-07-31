<?php
include("conn.php");

// Fetch student data from the database
$sql = "SELECT User_Name, Name FROM student";
$result = $conn->query($sql);
$students = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Function to compare usernames for sorting
function compareUsernames($a, $b) {
    return strcmp($a['User_Name'], $b['User_Name']);
}

// Check if the sort direction is specified and sort the array accordingly
if (isset($_GET['sort'])) {
    $sortDirection = $_GET['sort'];
    if ($sortDirection === 'asc') {
        usort($students, 'compareUsernames');
    } elseif ($sortDirection === 'desc') {
        usort($students, function ($a, $b) {
            return -compareUsernames($a, $b);
        });
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
    <link rel="stylesheet" href="../CSS/page6.css">
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../php/loginpage.php';
            }
        }
        function toggleSort() {
            var sortIcon = document.getElementById("sortIcon");
            var currentSort = sortIcon.dataset.sort;

            if (currentSort === "asc") {
                sortIcon.dataset.sort = "desc";
                sortIcon.innerHTML = "&#x25BC;"; // Downward arrow for descending
            } else {
                sortIcon.dataset.sort = "asc";
                sortIcon.innerHTML = "&#x25B2;"; // Upward arrow for ascending
            }
            alert("Sorting direction: " + sortIcon.dataset.sort);
        }
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success_message');
        if (successMessage) {
            alert(successMessage);
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
<main>
    <h1>DEACTIVATE ACCOUNT</h1>
    <span class="material-symbols-outlined">swap_vert</span>
    <button id="sort" onclick="toggleSort()">
            <a href="?sort=asc">Ascending &#x25B2;</a> / <a href="?sort=desc">Decending &#x25BC;</a></th> <!-- Default to ascending -->
        </button>
    <table id="studentTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Username </th>
            <th >STUDENT</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php
            foreach ($students as $index => $student) {
                echo "<tr>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>" . $student['User_Name'] . "</td>";
                echo "<td>" . $student['Name'] . "</td>";
                echo "<td>";
                echo "<form method='post' onsubmit='return confirm(\"Are you sure you want to deactivate this account?\")' action='deactivate1.php'>";
                echo "<input type='hidden' name='student_id' value='" . $student['User_Name'] . "'>";
                echo "<button type='submit' name='deactivate'>DEACTIVATE</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
      </table>
  </main>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  </body>
  </html>
