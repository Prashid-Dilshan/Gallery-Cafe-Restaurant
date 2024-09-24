<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="../assets/css/reservation done.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="message-box">
            <h1>Reservation Confirmed!</h1>
            <?php
          
            $reservation_time = isset($_GET['time']) ? htmlspecialchars($_GET['time']) : 'unknown time';
            ?>
            <p>Thank you for your reservation. Your table is ready for you at <span id="reservation-time"><?php echo $reservation_time; ?></span>.</p>
            <p>If you have any questions or need further assistance, please contact our support team.</p>
            <a href="../customer.php" class="back-btn">Back to Menu</a>
        </div>
    </div>
</body>
</html>
