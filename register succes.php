<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Registration Successful - Gallery Cafe</title>
    <link rel="stylesheet" href="./assets/css/register succes.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="message" id="message">
        <h1>Account Created Successfully!</h1>
        <div class="loading">
            <div></div>
        </div>
        <p>You will be redirected to your dashboard shortly...</p>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const message = document.getElementById('message');
            message.classList.add('show');


            setTimeout(function() {
                window.location.href = 'customer.php';
            }, 4000);
        });
        
    </script>
</body>
</html>
