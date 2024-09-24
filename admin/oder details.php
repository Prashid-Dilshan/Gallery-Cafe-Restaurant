<?php
session_start();
include '../db.php'; 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_GET['delete'])) {
    $cartId = intval($_GET['delete']);


    $sql = "SELECT user_id FROM cart WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['user_id'];

        // Delete from cart table
        $sql = "DELETE FROM cart WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cartId);
        if ($stmt->execute()) {
            
            // Check if there are no more items for this user in the cart
            $sql = "SELECT COUNT(*) AS count FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] == 0) {
                // If no items, delete delivery details as well
                $sql = "DELETE FROM cus_delivery_details WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }
            $stmt->close();
            $success = "Record deleted successfully.";
        } else {
            $error = "Failed to delete record. Please try again.";
        }
    } else {
        $error = "No record found.";
    }
}

// Fetch all orders with details
$sql = "SELECT 
            cart.id AS cart_id, 
            cart.user_id, 
            cart.food_name, 
            cart.food_photo, 
            cart.price, 
            cart.quantity, 
            cus_delivery_details.name, 
            cus_delivery_details.email, 
            cus_delivery_details.phone, 
            cus_delivery_details.address, 
            cus_delivery_details.city, 
            cus_delivery_details.payment_method
        FROM 
            cart 
        JOIN 
            cus_delivery_details ON cart.user_id = cus_delivery_details.user_id
        ORDER BY 
            cart.id DESC"; // Optionally order by cart id or date

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Customer Food Details</title>
    <link rel="stylesheet" href="../assets/css/admin oder details.css"> <
</head>
<body>
    <div class="admin-container">
        <h1>Customer Food Oder Details</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
 
        <?php if ($result->num_rows > 0): ?>
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Cart ID</th>
                        <th>User ID</th>
                        <th>Food Name</th>
                        <th>Food Photo</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cart_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                            <td><img src="../uploads/<?php echo htmlspecialchars($row['food_photo']); ?>" alt="Food Image" style="width: 100px;"></td>
                            <td>LKR. <?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['city']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td>
                                <a href="?delete=<?php echo htmlspecialchars($row['cart_id']); ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>










