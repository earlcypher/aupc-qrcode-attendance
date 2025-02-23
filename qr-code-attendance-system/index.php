<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navv">
        <a class="navbar-brand ml-4 navv-head" href="#">AUPC Attendance System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./masterlist.php">List of Students</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        
        <div class="attendance-container row">
            <div class="qr-container col-4">
                <div class="scanner-con">
                    <h5 class="text-center">Scan you QR Code here for your attedance</h5>
                    <video id="interactive" class="viewport" width="100%">
                </div>

                <div class="qr-detected-container" style="display: none;">
                    <form action="./endpoint/add-attendance.php" method="POST">
                        <h4 class="text-center">Student QR Detected!</h4>
                        <input type="hidden" id="detected-qr-code" name="qr_code">
                        <button type="submit" class="btn btn-dark form-control">Submit Attendance</button>
                    </form>
                </div>
            </div>

            <div class="attendance-list">
                <h4>List of Present Students</h4>
                <div class="table-container table-responsive">
                    <button class="btn btn-primary mb-2" onclick="downloadCSV()">Download Record</button>
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="clear_records" class="btn btn-danger mb-2">Clear Record</button>
                    </form>
                    <table class="table text-center table-sm" id="attendanceTable">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Strand & Section</th>
                            <th scope="col">LRN</th>
                            <th scope="col">Time In</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                include ('./conn/conn.php');
                            
                                if (isset($_POST['clear_records'])) {
                                    $stmt = $conn->prepare("DELETE FROM tbl_attendance");
                                    $stmt->execute();
                                }
                            
                                $stmt = $conn->prepare("SELECT tbl_attendance_id, student_name, course_section, lrn, DATE_FORMAT(time_in, '%Y-%m-%d %H:%i:%s') as time_in FROM tbl_attendance LEFT JOIN tbl_student ON tbl_student.tbl_student_id = tbl_attendance.tbl_student_id");
                                $stmt->execute();
                            
                                $result = $stmt->fetchAll();
                            
                                foreach ($result as $row) {
                                    $attendanceID = $row["tbl_attendance_id"];
                                    $studentName = $row["student_name"];
                                    $studentCourse = $row["course_section"];
                                    $studentLRN = $row["lrn"];
                                    $timeIn = $row["time_in"];
                            ?>

                                <tr>
                                    <th scope="row"><?= $attendanceID ?></th>
                                    <td><?= $studentName ?></td>
                                    <td><?= $studentCourse ?></td>
                                    <td><?= $studentLRN ?></td>
                                    <td><?= $timeIn ?></td>
                                    <td>
                                        <div class="action-button">
                                            <button class="btn btn-danger delete-button" onclick="deleteAttendance(<?= $attendanceID ?>)">X</button>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>

    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- instascan Js -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>

        
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content) {
                $("#detected-qr-code").val(content);
                console.log(content);
                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-con").style.display = 'none';
                document.querySelector(".qr-detected-container form").submit(); // Automatically submit the form
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        document.addEventListener('DOMContentLoaded', startScanner);

        function deleteAttendance(id) {
            if (confirm("Do you want to remove this attendance?")) {
                window.location = "./endpoint/delete-attendance.php?attendance=" + id;
            }
        }

        function downloadCSV() {
            let csv = 'Last Name,First Name & Middle Initial,Strand & Section,LRN,Date Today\n\n';
            const rows = document.querySelectorAll('#attendanceTable tbody tr');
            rows.forEach(row => {
            const cols = row.querySelectorAll('td');
            const rowData = [
            cols[0].innerText, // Name
            cols[1].innerText, // Strand & Section
            cols[2].innerText, // Lrn
            '"' + cols[3].innerText + '"'  // Date Today
            ];
            const rows = rowData.join(",");
            csv += rows + '\r\n';
            });

            const blob = new Blob([csv], { type: 'data:text/csv;charset=utf-8,' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'attendance_records.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
        function showDateToday() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
            const time = today.getHours().toString().padStart(2, '0') + ":" + today.getMinutes().toString().padStart(2, '0') + ":" + today.getSeconds().toString().padStart(2, '0');
            const dateTime = date + ' ' + time;
            return dateTime;
        }

        function downloadCSV() {
            let csv = 'Last Name,First Name & Middle Initial,Strand & Section,LRN,Date Today\n';
            const rows = document.querySelectorAll('#attendanceTable tbody tr');
            rows.forEach(row => {
            const cols = row.querySelectorAll('td');
            const rowData = [
                cols[0].innerText, // Name
                cols[1].innerText, // Strand & Section
                cols[2].innerText, // Lrn
                showDateToday()  // Date Today
            ];
            const rows = rowData.join(",");
            csv += rows + '\r\n';
            });

            const blob = new Blob([csv], { type: 'data:text/csv;charset=utf-8,' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'attendance_records.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function downloadQRCode() {
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
                link.download = 'aupc-qrcode.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
        }
    </script>
</body>
</html>