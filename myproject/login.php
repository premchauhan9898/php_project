<?php
$conn = new mysqli("localhost", "root", "Prem@6972", "user_db");

if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $rows = $result->fetch_assoc();
        if($rows["password"] == $password) {
            $name = $rows["user_name"];
            echo "<h1> Dashboard </h1>";
            echo "<h3>Welcome $name</h3>";
        } else echo "Password didn't match. Click <a href='login.html'>here</a> to try again.";
    }
    else echo "Email not found <br><br><a href='login.html'>Go Back</a>"; 
}




?>