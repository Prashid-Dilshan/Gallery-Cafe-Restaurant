<?php
session_start();
include '../db.php'; 

$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $cardNumber = $_POST['card_number'] ?? '';
    $cardName = $_POST['card_name'] ?? '';
    $expiryDate = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $billingAddress = $_POST['billing_address'] ?? '';

   
    if (empty($cardNumber) || empty($cardName) || empty($expiryDate) || empty($cvv) || empty($billingAddress)) {
        $error = 'Please fill in all fields.';
    } else {
       
        $paymentSuccessful = true; 

        if ($paymentSuccessful) {
           
            header('Location: ../Customer/Preoder done.php');
            exit();
        } else {
           
            $error = 'Payment failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
    <link rel="stylesheet" href="../assets/css/card details.css">
</head>
<body>
    <div class="payment-container">
        <a href="../Customer/cus delivery details.php" class="back-btn">Back to Menu</a>
        
        <h1>Payment Details</h1>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="payment-form">
            <div class="card-details">
                <label for="card-number">Card Number:</label>
                <div class="card-input">
                    <input type="text" id="card-number" name="card_number" placeholder="Card Number" maxlength="19" required>
                    <img src="../assets/images/visa_card.png" alt="Card Icons" class="card-icons">
                </div>

                <label for="card-name">Cardholder Name:</label>
                <input type="text" id="card-name" name="card_name" placeholder="Name" required>

                <div class="expiry-cvv">
                    <div>
                        <label for="expiry-date">Expiry Date:</label>
                        <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div>
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" maxlength="3" required>
                    </div>
                </div>

                <label for="billing-address">Billing Address:</label>
                <input type="text" id="billing-address" name="billing_address" placeholder="Address" required>
            </div>
            
            <button type="submit" class="submit-btn">Pay Now</button>
        </form>
    </div>
</body>
</html>
