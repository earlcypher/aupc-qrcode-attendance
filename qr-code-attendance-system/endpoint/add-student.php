<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_name'], $_POST['course_section'])) {
        $studentName = $_POST['student_name'];
        $studentCourse = $_POST['course_section'];
        $generatedCode = $_POST['generated_code'];
        $age = $_POST['age'];
        $birthday = $_POST['birthday'];
        $lrn = $_POST['lrn'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_student (student_name, course_section, generated_code, age, birthday, lrn, email, contact) VALUES (:student_name, :course_section, :generated_code, :age, :birthday, :lrn, :email, :contact)");
            
            $stmt->bindParam(":student_name", $studentName, PDO::PARAM_STR); 
            $stmt->bindParam(":course_section", $studentCourse, PDO::PARAM_STR);
            $stmt->bindParam(":generated_code", $generatedCode, PDO::PARAM_STR);
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
