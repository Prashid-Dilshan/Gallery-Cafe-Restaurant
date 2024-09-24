<?php
session_start();
include '../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

$userId = $_SESSION['user_id'];

// Fetch the latest order for the user
$sql = "SELECT * FROM preorder_details WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();
$stmt->close();

if ($order) {
    $orderId = $order['id'];

    // Fetch items for the latest order
    $sql = "SELECT * FROM preorder_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();

    $orderItems = [];
    while ($row = $itemsResult->fetch_assoc()) {
        $orderItems[] = $row;
    }
    $stmt->close();
} else {
    $error = "No preorder details found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preorder Details</title>
    <link rel="stylesheet" href="../assets/css/preoder details.css"> 
</head>
<body>
    <div class="preorder-details-container">

        <h1>Preorder Details</h1>

        <?php if (isset($order) && $order): ?>
            <div class="customer-details">
                <h2>Customer Details</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
            </div>

            <h2>Ordered Items</h2>
            <div class="order-items">
                <?php if (!empty($orderItems)): ?>
                    <?php foreach ($orderItems as $item): ?>
                        <div class="order-item">
                            <img src="../uploads/<?php echo htmlspecialchars($item['food_photo']); ?>" alt="Food Image">
                            <div class="order-item-details">
                                <h3><?php echo htmlspecialchars($item['food_name']); ?></h3>
                                <p class="price">LKR. <?php echo htmlspecialchars($item['price']); ?></p>
                                <p class="quantity">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items in this order.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>


