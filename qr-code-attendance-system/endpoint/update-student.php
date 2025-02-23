<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tbl_student_id'], $_POST['student_name'], $_POST['course_section'], $_POST['age'], $_POST['birthday'], $_POST['lrn'], $_POST['email'], $_POST['contact'])) {
        $studentId = $_POST['tbl_student_id'];
        $studentName = $_POST['student_name'];
        $studentCourse = $_POST['course_section'];
        $age = $_POST['age'];
        $birthday = $_POST['birthday'];
        $lrn = $_POST['lrn'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        try {
            $stmt = $conn->prepare("UPDATE tbl_student SET student_name = :student_name, course_section = :course_section, age = :age, birthday = :birthday, lrn = :lrn, email = :email, contact = :contact WHERE tbl_student_id = :tbl_student_id");
            
            $stmt->bindParam(":tbl_student_id", $studentId, PDO::PARAM_STR); 
            $stmt->bindParam(":student_name", $studentName, PDO::PARAM_STR); 
            $stmt->bindParam(":course_section", $studentCourse, PDO::PARAM_STR);
            $stmt->bindParam(":age", $age, PDO::PARAM_INT);
            $stmt->bindParam(":birthday", $birthday, PDO::PARAM_STR);
            $stmt->bindParam(":lrn", $lrn, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":contact", $contact, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: http://localhost/qr-code-attendance-system/masterlist.php");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/qr-code-attendance-system/masterlist.php';
            </script>
        ";
    }
}
?>
