<?php
    session_start();
    include ('../conn/conn.php');

    $lrn = $_SESSION['lrn']; // Assuming LRN is stored in session
    $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE lrn = :lrn");
    $stmt->bindParam(':lrn', $lrn);
    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach ($result as $row) {
        $studentID = $row["tbl_student_id"];
        $studentName = $row["student_name"];
        $studentCourse = $row["course_section"];
        $qrCode = $row["generated_code"];
        $age = $row["age"];
        $birthday = $row["birthday"];
        $lrn = $row["lrn"];
        $email = $row["email"];
        $contact = $row["contact"];
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="index.js"></script>
    <title>Home</title>

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    
</head>
<body>
<header class="nav">
    <div class="logo">AUPC Attendance</div>
    <button class="btn" onclick="location.href='logout.php'">Logout</button>
</header>

<main class="main-container">
    <section class="box-container">
        <div class="header-container">
            <h1 id="form-header" class="header">Student QR Code</h1>
        </div>
        
        <div class="button-container">
            <a href="#" id="btnPerson" onclick="showForm('form1', 'Student Profile')">
                <span class="material-icons md-18">person</span>
            </a>
            <a href="#" id="btnQR" onclick="showForm('form2', 'Student QR Code')">
                <span class="material-icons md-18">qr_code</span>
            </a>
        </div>
        
        <div class="form-container">
            <div class="form-box box1" id="form2">
                <div class="qr-img">
                    <img id="qrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $qrCode ?>" alt="" width="200"><br>
                </div>
                <button id="qr-btn" onclick="downloadQRCode('<?= $studentName ?>')">Download QR-Code</button>
            </div>
            <div class="form-box box2" id="form1">
                <label><b><?php echo $studentName; ?></b></label>
                <br>Student Name<br><br>
                <label><b><?php echo $studentCourse; ?></b></label>
                <br>Strand & Section<br><br>
                <label><b><?php echo $lrn; ?></b></label>
                <br>Student LRN<br><br>
                <label><b><?php echo $age; ?></b></label>
                <br>Student Age<br><br>
                <label><b><?php echo $birthday; ?></b></label>
                <br>Student's Birthday<br><br>
                <label><b><?php echo $email; ?></b></label>
                <br>Student Email<br><br>
                <label><b><?php echo $contact; ?></b></label>
                <br>Student Contact<br>
            </div>
        </div>
        <script>
            function downloadQRCode(studentName) {
                const qrImage = document.getElementById('qrImage');
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.src = qrImage.src;
                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img, 0, 0);
                    const dataURL = canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.href = dataURL;
                    link.download = studentName + '(AUPC-QRCODE).jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };
            }
        </script>
    </section>
</main>
</body>
</html>