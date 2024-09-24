<?php
session_start();
include '../db.php'; 

if (isset($_POST['login'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));


    $stmt = $conn->prepare("SELECT id, password FROM staff_details WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        

        if (password_verify($password, $hashed_password)) {

            $_SESSION['staff_id'] = $id;
            $_SESSION['staff_email'] = $email;
            header("Location: staff.php"); 
            exit();
        } else {
            $login_error = "Invalid email or password.";
        }
    } else {
        $login_error = "Invalid email or password.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="../assets/css/staff login.css">
    
</head>
<body>
    <div class="login-container">
        <h2>Staff Login</h2>
        <?php if (isset($login_error)) echo "<p class='error-message'>$login_error</p>"; ?>
        <form method="post" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
