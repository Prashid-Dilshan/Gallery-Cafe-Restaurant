<?php
session_start();
include '../db.php'; 

$userId = $_SESSION['user_id']; 

$sql = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$cartResult = $stmt->get_result();

$totalPrice = 0;
$cartItems = [];

while ($row = $cartResult->fetch_assoc()) {
    $cartItems[] = $row;
    $totalPrice += $row['price'] * $row['quantity'];
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_delivery_details'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($payment_method)) {
        $error = "Please fill all fields.";
    } else {
        $sql = "INSERT INTO cus_delivery_details (user_id, name, email, phone, address, city, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("issssss", $userId, $name, $email, $phone, $address, $city, $payment_method);
            if ($stmt->execute()) {
                $success = "Delivery details saved successfully!";

                if ($payment_method == 'Credit Card') {
                    header("Location: Card details.php");
                    exit();
                } else if ($payment_method == 'Cash On Delivery') {
                    header("Location: COD purchase.php");
                    exit();
                }
            } else {
                $error = "Failed to save details. Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart and Delivery Details</title>
    <link rel="stylesheet" href="../assets/css/cus delivery details.css"> 
</head>
<body>

    <div class="cart-container">
    <div class="back-button-container">
        <a href="cus Food.php" class="back-button">Back to Food Menu</a>
    </div>
    
        <h1>Your Cart</h1>

        <div class="cart-items">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <img src="../uploads/<?php echo htmlspecialchars($item['food_photo']); ?>" alt="Food Image">
                        <div class="cart-item-details">
                            <h3><?php echo htmlspecialchars($item['food_name']); ?></h3>
                            <p class="price">LKR. <?php echo htmlspecialchars($item['price']); ?></p>
                            <p class="quantity">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="total-price">
                    <h3>Total Price: LKR. <?php echo htmlspecialchars($totalPrice); ?></h3>
                </div>
            <?php else: ?>
                <p>No items in cart.</p>
            <?php endif; ?>
        </div>

        <h2>Enter Delivery Details</h2>
        <form id="delivery-form" action="" method="post" class="delivery-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <div class="payment-method-container">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="Cash On Delivery">Cash On Delivery</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
                <button type="submit" name="save_delivery_details">Place Order</button>
            </div>
        </form>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
