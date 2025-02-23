<?php
    session_start();
    include("../database/db.php");

    if (isset($_POST["submit"])) {
        $lrn = mysqli_real_escape_string($conn, $_POST["lrn"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
    
        $sql = "SELECT * FROM tb_users WHERE lrn = '$lrn' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: home.php");
            exit;
        } else {
            echo "<script>alert('Invalid LRN or Password');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header class="head">Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="lrn">Student LRN</label>
                    <input type="number" name="lrn" id="lrn" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>