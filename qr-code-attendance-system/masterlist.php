<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUPC Attendance System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

</head>
<body>
    <nav class="navbar navbar-expand-lg navv">
        <a class="navbar-brand ml-4 navv-head" href="#">AUPC Attendance System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
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
        
        <div class="student-container">
            <div class="student-list">
                <div class="title">
                    <h4>List of Students</h4>
                    <button class="btn btn-dark" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
                </div>
                <hr>
                <div class="table-container table-responsive">
                    <table class="table text-center table-sm" id="studentTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Strand & Section</th>
                                <th scope="col">Age</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">LRN</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                include ('./conn/conn.php');

                                $stmt = $conn->prepare("SELECT * FROM tbl_student");
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
                                ?>

                                <tr>
                                    <th scope="row" id="studentID-<?= $studentID ?>"><?= $studentID ?></th>
                                    <td id="studentName-<?= $studentID ?>"><?= $studentName ?></td>
                                    <td id="studentCourse-<?= $studentID ?>"><?= $studentCourse ?></td>
                                    <td id="studentAge-<?= $studentID ?>"><?= $age ?></td>
                                    <td id="studentBirthday-<?= $studentID ?>"><?= $birthday ?></td>
                                    <td id="studentLrn-<?= $studentID ?>"><?= $lrn ?></td>
                                    <td id="studentEmail-<?= $studentID ?>"><?= $email ?></td>
                                    <td id="studentContact-<?= $studentID ?>"><?= $contact ?></td>
                                    <td>
                                        <div class="action-button">
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#qrCodeModal<?= $studentID ?>"><img src="https://cdn-icons-png.flaticon.com/512/1341/1341632.png" alt="" width="16"></button>

                                            <!-- QR Modal -->
                                            <div class="modal fade" id="qrCodeModal<?= $studentID ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $studentName ?>'s QR Code</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $qrCode ?>" alt="" width="300">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" id="qr-btn" onclick="downloadQRCode('<?= $studentID ?>', '<?= $studentName ?>')">Download QR-Code</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-secondary btn-sm" onclick="updateStudent(<?= $studentID ?>)">&#128393;</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteStudent(<?= $studentID ?>)">&#10006;</button>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addStudent" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudent">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/add-student.php" method="POST">
                        <div class="form-group">
                            <label for="studentName">Last Name, First Name, MI:</label>
                            <input type="text" class="form-control" id="studentName" name="student_name">
                        </div>
                        <div class="form-group">
                            <label for="studentCourse">Strand and Section:</label>
                            <input type="text" class="form-control" id="studentCourse" name="course_section">
                        </div>
                        <div class="form-group">
                            <label for="studentAge">Age:</label>
                            <input type="number" class="form-control" id="studentAge" name="age">
                        </div>
                        <div class="form-group">
                            <label for="studentBirthday">Birthday:</label>
                            <input type="date" class="form-control" id="studentBirthday" name="birthday">
                        </div>
                        <div class="form-group">
                            <label for="studentLrn">LRN:</label>
                            <input type="text" class="form-control" id="studentLrn" name="lrn">
                        </div>
                        <div class="form-group">
                            <label for="studentEmail">Email:</label>
                            <input type="email" class="form-control" id="studentEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="studentContact">Contact:</label>
                            <input type="tel" class="form-control" id="studentContact" name="contact" pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                        </div>
                        <button type="button" class="btn btn-secondary form-control qr-generator" onclick="generateQrCode()">Generate QR Code</button>

                        <div class="qr-con text-center" style="display: none;">
                            <input type="hidden" class="form-control" id="generatedCode" name="generated_code">
                            <p>Take a pic with your qr code.</p>
                            <img class="mb-4" src="" id="qrImg" alt="">
                        </div>
                        <div class="modal-footer modal-close" style="display: none;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Add List</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateStudent" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStudent">Update Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-student.php" method="POST">
                        <input type="hidden" class="form-control" id="updateStudentId" name="tbl_student_id">
                        <div class="form-group">
                            <label for="updateStudentName">Last Name, First Name, MI:</label>
                            <input type="text" class="form-control" id="updateStudentName" name="student_name">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentCourse">Strand and Section:</label>
                            <input type="text" class="form-control" id="updateStudentCourse" name="course_section">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentAge">Age:</label>
                            <input type="number" class="form-control" id="updateStudentAge" name="age">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentBirthday">Birthday:</label>
                            <input type="date" class="form-control" id="updateStudentBirthday" name="birthday">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentLrn">LRN:</label>
                            <input type="text" class="form-control" id="updateStudentLrn" name="lrn">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentEmail">Email:</label>
                            <input type="email" class="form-control" id="updateStudentEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="updateStudentContact">Contact:</label>
                            <input type="text" class="form-control" id="updateStudentContact" name="contact">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready( function () {
            $('#studentTable').DataTable();
        });

        function updateStudent(id) {
            $("#updateStudentModal").modal("show");

            let updateStudentId = $("#studentID-" + id).text();
            let updateStudentName = $("#studentName-" + id).text();
            let updateStudentCourse = $("#studentCourse-" + id).text();
            let updateStudentAge = $("#studentAge-" + id).text();
            let updateStudentBirthday = $("#studentBirthday-" + id).text();
            let updateStudentLrn = $("#studentLrn-" + id).text();
            let updateStudentEmail = $("#studentEmail-" + id).text();
            let updateStudentContact = $("#studentContact-" + id).text();

            $("#updateStudentId").val(updateStudentId);
            $("#updateStudentName").val(updateStudentName);
            $("#updateStudentCourse").val(updateStudentCourse);
            $("#updateStudentAge").val(updateStudentAge);
            $("#updateStudentBirthday").val(updateStudentBirthday);
            $("#updateStudentLrn").val(updateStudentLrn);
            $("#updateStudentEmail").val(updateStudentEmail);
            $("#updateStudentContact").val(updateStudentContact);
        }

        function deleteStudent(id) {
            if (confirm("Do you want to delete this student?")) {
                window.location = "./endpoint/delete-student.php?student=" + id;
            }
        }

        function generateRandomCode(length) {
            const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            let randomString = '';

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomString += characters.charAt(randomIndex);
            }

            return randomString;
        }

        function generateQrCode() {
            const qrImg = document.getElementById('qrImg');

            let text = generateRandomCode(10);
            $("#generatedCode").val(text);

            if (text === "") {
                alert("Please enter text to generate a QR code.");
                return;
            } else {
                const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(text)}`;

                qrImg.src = apiUrl;
                document.getElementById('studentName').style.pointerEvents = 'none';
                document.getElementById('studentCourse').style.pointerEvents = 'none';
                document.querySelector('.modal-close').style.display = '';
                document.querySelector('.qr-con').style.display = '';
                document.querySelector('.qr-generator').style.display = 'none';
            }
        }

        function downloadQRCode(studentID, studentName) {
            const qrImage = document.querySelector(`#qrCodeModal${studentID} img`);
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
    
</body>
</html>