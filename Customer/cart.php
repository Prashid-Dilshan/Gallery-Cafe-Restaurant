<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $foodItemId = intval($_GET['delete']);
    $deleteSql = "DELETE FROM cart WHERE user_id = ? AND food_item_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("ii", $userId, $foodItemId);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../assets/css/cart.css"> 
</head>
<body>
    <div class="checkout-container">
        <a href="../Customer/cus food.php" class="back-btn">Back to Shop</a> 
        <h1>Cart</h1>
        
        <?php if (!empty($cartItems)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['food_name']); ?></td>
                            <td><img src="../uploads/<?php echo htmlspecialchars($item['food_photo']); ?>" alt="Food Image" width="100"></td>
                            <td>LKR. <?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>LKR. <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                            <td>
                                <a href="?delete=<?php echo htmlspecialchars($item['food_item_id']); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to remove this item?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total Price: LKR. <?php echo $totalPrice; ?></p>
            <form action="../Customer/cus delivery details.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                <button type="submit" class="checkout-btn">Complete Purchase</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
