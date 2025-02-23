<?php
    session_start();
    include("../database/db.php");

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
        exit;
    }
    
    $id = $_SESSION["id"];
    $sql = "SELECT * FROM tb_users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $name = $row["name"];
    $email = $row["email"];
    $password = $row["password"];
    $regdate = $row["reg_date"];
    $lrn = $row["lrn"];
    $grade = $row["grade"];
    $section = $row["section"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../js/index.js"></script>
    <title>Home</title>
</head>
<body>
<header class="nav">
    <div class="logo">AUPC Attendance</div>
    <button class="btn" onclick="location.href='../backend/logout.php'">Log Out</button>
</header>

<main class="main-container">
    <section class="box-container">
        <div class="header-container">
            <h1 id="form-header" class="header">Student Profile</h1>
        </div>
        
        <div class="button-container">
            <a href="#" id="btnPerson" onclick="showForm('form1', 'Student')">
                <span class="material-icons md-18">person</span>
            </a>
            <a href="#" id="btnQR" onclick="showForm('form2', 'QR Code')">
                <span class="material-icons md-18">qr_code</span>
            </a>
        </div>
        
        <div class="form-container">
            <div class="form-box" id="form2">
                <p>QR Code Here</p>
            </div>
            <div class="form-box" id="form1">
                Student Name: <b><?php echo $name; ?></b><br>
                Email: <b><?php echo $email; ?></b><br>
                LRN: <b><?php echo $lrn; ?></b><br>
                Grade: <b><?php echo $grade; ?></b><br>
                Section: <b><?php echo $section; ?></b><br>
                Password: <b><?php echo $password; ?></b><br>
                Registered Date: <b><?php echo $regdate; ?></b>
            </div>
        </div>
    </section>
</main>
</body>
</html>
