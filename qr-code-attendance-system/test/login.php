<?php
    session_start();
    include("../conn/conn.php");
    if (isset($_POST["submit"])) {
        $lrn = $_POST["lrn"];

        $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE lrn = :lrn");
        $stmt->bindParam(":lrn", $lrn, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION["student_id"] = $result["tbl_student_id"];
            $_SESSION["student_name"] = $result["student_name"];
            $_SESSION["course_section"] = $result["course_section"];
            $_SESSION["age"] = $result["age"];
            $_SESSION["birthday"] = $result["birthday"];
            $_SESSION["lrn"] = $result["lrn"];
            $_SESSION["email"] = $result["email"];
            $_SESSION["contact"] = $result["contact"];

            header("Location: home.php");
            exit();
        } else {
            echo "
                <script>
                    alert('Student not found!');
                    window.location.href = 'http://localhost/qr-code-attendance-system/login.php';
                </script>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="contact.php">Contact Your Adviser</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
