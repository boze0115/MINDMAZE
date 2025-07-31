<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<link rel="stylesheet" href="../CSS/studentsighuppage.css">
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
        <button class="user-type active">Student</button>
        <form action="../php/teachersignuppage.php">
          <button class="user-type">Teacher</button>
        </form>
      </div>
      <h2>Register a New Account</h2>
      <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $Username=$_POST['username'];
          $Name=$_POST['name'];
          $EmailAddress=$_POST['email'];
          $PhoneNum=$_POST['phone'];
          $Password=$_POST['password'];
          $Teacher=$_POST['teacher'];

          $conn=new mysqli('localhost','root','','mindmaze');
          if($conn->connect_error){
              die('Connection Failed :'.$conn->connect_error);
          } else {
              // Check if the username already exists
              $check_stmt = $conn->prepare('SELECT * FROM STUDENT WHERE User_Name = ?');
              $check_stmt->bind_param('s', $Username);
              $check_stmt->execute();
              $check_result = $check_stmt->get_result();
          
              if ($check_result->num_rows > 0) {
                  echo 'Username already exists. Please choose a different username.';
              } else {
                  // Insert the record into the database
                  $stmt=$conn->prepare('INSERT INTO STUDENT(User_Name,Name,PhoneNum,EmailAddress,Password,Teach_Name) VALUES(?,?,?,?,?,?)');
                  $stmt->bind_param('ssssss', $Username, $Name, $PhoneNum, $EmailAddress, $Password, $Teacher);
                  $stmt->execute();
                  echo 'Registration successful';
                  //redirect link to other page
                  echo '<script>window.location.href = "../php/loginpage.php";</script>'; // JavaScript redirect
              }
          }
        } 
      ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateUsername()">
        <input type="text" placeholder="Username" name="username" id="username" required>
        <input type="text" placeholder="Name" name="name" required>
        <input type="email" placeholder="Email Address" name="email" required>
        <input type="password" placeholder="Password" name="password" required>
        <input type="tel" placeholder="Phone Number" name="phone" required>
        <label for="teacher">Teacher</label>
        <select id="teacher" name="teacher">
          <?php
            // Step 1: Connect to your database
            $conn = new mysqli('localhost', 'root', '', 'mindmaze');
            if ($conn->connect_error) {
                die('Connection Failed: ' . $conn->connect_error);
            }

            // Step 2: Fetch teacher names from the database
            $sql = "SELECT Teach_Name FROM TEACHER";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $teacher_name = $row['Teach_Name'];
                    echo "<option value='$teacher_name'>$teacher_name</option>";
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
      var username = document.getElementById("username").value;
      if (username.length < 5) {
        alert("Username must be at least 5 characters long");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
