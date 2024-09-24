<?php
session_start();

// Define credentials
$admin_username = 'admin1';
$admin_password = 'admin1'; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if ($email === $admin_username && $password === $admin_password) {

        $_SESSION['user_id'] = $email;
        header("Location: Admin.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Login - Gallery Cafe</title>
    <link rel="stylesheet" href="../assets/css/Admin login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="wrapper">
            <div class="title login">
               Admin Login
            </div>

        <div class="form-container">
            <div class="form-inner">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login">
                    <?php if (isset($error)): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <div class="field">
                        <input type="text" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="login" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
