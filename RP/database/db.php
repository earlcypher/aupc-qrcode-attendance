<?php  
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "rp_db";
    $conn = "";

    try {
        $conn = mysqli_connect(
            $db_server,
            $db_user,
            $db_pass,
            $db_name);
    } catch (mysqli_sql_exception) {
         echo"db is not connected! <br>";
    }
?>