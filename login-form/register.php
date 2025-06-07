<?php
$conn = new mysqli("localhost", "root", "Prem@6972", "user_db");

if($conn->connect_error) {
    die("Connection failed".$conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["student_name"];
    $email = $_POST["student_email"];
    $password = $_POST["student_password"];
    $confirmedPass = $_POST["confirmed_password"];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "Email already exists, Please login with the same email or enter a new email to create another account!<br>";
        echo "<a href='register.html'>Go Back</a> <br>";
        echo "<a href='login.html'>Login</a>";
    }
    else {
        $insertsql = "INSERT INTO users(user_name, email, password) values(?, ?, ?)";
        $insertStmt = $conn->prepare($insertsql);
        $insertStmt->bind_param("sss", $name, $email, $password);

        if($insertStmt->execute()) {
            echo "Your details have been added to the database successfully <br><br>";
            echo "<a href='login.html'>Login</a>";
        }
    }

    if($confirmedPass != $password) {
        echo "The password didn't match, please check for the password again! <br><br>";
        echo "<a href='register.html'>Go back</a>";
        exit;
    }

}
?>