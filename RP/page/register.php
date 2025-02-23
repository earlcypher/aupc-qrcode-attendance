<?php
    include("../database/db.php");
    if(isset($_POST["submit"]))
    {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $lrn = $_POST["lrn"];
        $password = $_POST["password"];
        $grade = $_POST["grade"];
        $section = $_POST["section"];

        $sql = "INSERT INTO tb_users (lrn,email,name,grade,section,password)
                VALUES ('$lrn', '$email', '$username', '$grade', '$section', '$password')";
        try {
            mysqli_query($conn, $sql);
            echo "<script> alert('Registration Successfully!')</script>";
        } catch (mysqli_sql_exception) {
            echo "<script> alert('Student Name or Email Has Already Taken')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <header class="head">Sign Up</header>
            <form action="" method="post">
                
                <div class="field input">
                    <label for="username">Student Name (Last Name,First Name,Mi)</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="grade">Grade Level</label>
                    <input type="number" name="grade" id="grade" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="section">Section</label>
                    <input type="text" name="section" id="section" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="lrn">LRN</label>
                    <input type="number" name="lrn" id="lrn" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                
                <div class="links">
                    Already have Account? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
      </div>
</body>
</html>