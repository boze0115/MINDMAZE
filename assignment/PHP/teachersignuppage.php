<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<link rel="stylesheet" href="../CSS/teachersignuppage.css">
<script>
  function goToLoginPage() {
    window.location.href = "../php/loginpage.php";
  }
</script>
</head>
<body>
  <div class="container">
    <div class="welcome-section">
      <div class="logo">
        <img src="../image/newlogo.png" alt="">
        <class class="paragraph">
            <h1>Hello Friend !</h1><br>
            <p>Please provide the information to register your account</p>
        </class>
      </div>
    </div>
    <div class="form-section">
      <div class="form-header">
        <form action="../PHP/studentsignuppage.php">
            <button class="user-type active">Student</button>
        </form>
        <button class="user-type">Teacher</button>
      </div>
      <h2>Register a New Account</h2>
      <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $Username=$_POST['username'];
          $Name=$_POST['name'];
          $EmailAddress=$_POST['email'];
          $PhoneNum=$_POST['phone'];
          $Password=$_POST['password'];
          $Admin=$_POST['admin'];

          $conn=new mysqli('localhost','root','','mindmaze');
          if($conn->connect_error){
              die('Connection Failed :'.$conn->connect_error);
          } else {
              // Check if the username already exists
              $check_stmt = $conn->prepare('SELECT * FROM TEACHER WHERE Teach_Name = ?');
              $check_stmt->bind_param('s', $Username);
              $check_stmt->execute();
              $check_result = $check_stmt->get_result();
          
              if ($check_result->num_rows > 0) {
                  echo 'Username already exists. Please choose a different username.';
              } else {
                  // Insert the record into the database
                  $stmt=$conn->prepare('INSERT INTO TEACHER(Teach_Name,Name,PhoneNum,EmailAddress,Password,Admin_Name) VALUES(?,?,?,?,?,?)');
                  $stmt->bind_param('ssssss', $Username, $Name, $PhoneNum, $EmailAddress, $Password, $Admin);
                  $stmt->execute();
                  echo 'Registration successful';
                  //redirect link to other page
                  echo '<script>window.location.href = "../php/loginpage.php";</script>'; // JavaScript redirect
              }
          }
        }
      ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateUsername()">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>

        <label for="admin">Admin</label>
        <select id="admin" name="admin">
          <?php
            // Step 1: Connect to your database
            $conn = new mysqli('localhost', 'root', '', 'mindmaze');
            if ($conn->connect_error) {
                die('Connection Failed: ' . $conn->connect_error);
            }

            // Step 2: Fetch admin names from the database
            $sql = "SELECT Admin_Name FROM TEACHER";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $admin_name = $row['Admin_Name'];
                    echo "<option value='$admin_name'>$admin_name</option>";
                }
            }

            // Close database connection
            $conn->close();
          ?>
        </select>
        
        <button type="submit">Sign Up</button>
        <button type="button" onclick="goToLoginPage()">Back</button>
        
      </form>
    </div>
  </div>

  <script>
    function validateUsername() {
      var username = document.getElementsByName("username")[0].value;
      if (username.length < 5) {
        alert("Username must be at least 5 characters long");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
