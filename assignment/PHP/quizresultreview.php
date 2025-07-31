<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/page1.css">
    <script>
        function logoutConfirmation() {
            var confirmation = confirm('Are you sure want to logout?');
            if (confirmation) {
                window.location.href = '../php/loginpage.php' 
            }
        }
        function filterQuizzes() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("quizTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Index 1 corresponds to the quiz title column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
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
        <h3>Quiz Question Analysis</h3>
        <div class="search">
            <ion-icon name="search" class="search-icon"></ion-icon>
            <input id="searchInput" class="topnav" type="text" placeholder="Search.." onkeyup="filterQuizzes()">
        </div>
    </div>
    <div class="info">
        <div class="table">
            <table id="quizTable" class="content-table">
                <thead>
                    <tr>
                    <th colspan="3">TOPIC</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Include database connection file
                    include("conn.php");

                    // Fetch quiz titles from the database
                    $sql = "SELECT quiz_title FROM quiz";
                    $result = $conn->query($sql);

                    $index = 1;

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Echo the quiz title in each table row
                            echo "<tr>";
                            echo "<td class='number' style='width:15%;'>" . $index . "</td>";
                            echo "<td class='number' style='width:80%;'>" . $row["quiz_title"] . "</td>";
                            echo "<td></td>";
                            // Echo the eye icon with a link to a PHP page passing the quiz title as a parameter
                            echo "<td class='view'><a href='quizdetails.php?title=" . urlencode($row["quiz_title"]) . "'><ion-icon name='eye'></ion-icon></a></td>";
                            echo "</tr>";
                            $index++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>0 results</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

</body>
</html>