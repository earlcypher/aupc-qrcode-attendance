<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <header class="head">Contact Your Adviser</header>
            <form action="" method="post">
                
                <div class="p-container">
                    <p>Ma'am Aileen Codera is your adviser. Contact her for your account registration.</p>
                    <br>
                    <p>Adviser's Email:</p>
                    <a href="gmail.com">Gmail</a>
                    <p>Adviser's Contact:</p>
                    <a href="#">09123456789</a>
                    <br>
                    <br>
                </div>
                
                <div class="links">
                    Already have Account? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
      </div>
</body>
</html>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $lrn = $_POST['lrn'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'attendance_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO contacts (username, grade, section, lrn, email, password) VALUES ('$username', '$grade', '$section', '$lrn', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New contact created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
