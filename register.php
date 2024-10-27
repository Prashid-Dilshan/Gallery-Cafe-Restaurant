<?php
include 'db.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {


            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashed_password);
            $stmt->execute();


            $inserted_user_id = $stmt->insert_id;


            session_start();
            $_SESSION['user_id'] = $inserted_user_id;
            header("Location: register succes.php");
            exit();
        }
        $stmt->close();
    }
    $conn->close();
}
?>

