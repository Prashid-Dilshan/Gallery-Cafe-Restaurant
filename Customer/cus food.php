<?php
session_start();
include '../db.php'; 

$categoriesSql = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesSql);

$selectedCategory = '';
$foodItems = [];

if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];
    if ($selectedCategory == '') {
        $sql = "SELECT * FROM food_items";
        $result = $conn->query($sql);
        $foodItems = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $stmt = $conn->prepare("SELECT * FROM food_items WHERE category = ?");
        $stmt->bind_param("s", $selectedCategory);
        $stmt->execute();
        $result = $stmt->get_result();
        $foodItems = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    $sql = "SELECT * FROM food_items";
    $result = $conn->query($sql);
    $foodItems = $result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['food_item_id'])) {
    if (isset($_SESSION['user_id'])) {
        $foodItemId = $_POST['food_item_id'];
        $quantity = $_POST['quantity'];
        $userId = $_SESSION['user_id']; 

        $foodSql = "SELECT name, image, price FROM food_items WHERE id = ?";
        $stmt = $conn->prepare($foodSql);
        $stmt->bind_param("i", $foodItemId);
        $stmt->execute();
        $foodResult = $stmt->get_result()->fetch_assoc();

        if ($foodResult) {
            $foodName = $foodResult['name'];
            $foodPhoto = $foodResult['image'];
            $price = $foodResult['price'];

            $cartSql = "SELECT id FROM cart WHERE user_id = ? AND food_item_id = ?";
            $stmt = $conn->prepare($cartSql);
            $stmt->bind_param("ii", $userId, $foodItemId);
            $stmt->execute();
            $cartResult = $stmt->get_result();

            if ($cartResult->num_rows > 0) {
                $updateSql = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND food_item_id = ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("iii", $quantity, $userId, $foodItemId);
            } else {
                $insertSql = "INSERT INTO cart (user_id, food_item_id, food_name, food_photo, price, quantity) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertSql);
                $stmt->bind_param("iissdi", $userId, $foodItemId, $foodName, $foodPhoto, $price, $quantity);
            }

            if ($stmt->execute()) {
                echo "Item added to cart successfully.";
            } else {
                echo "Error adding item to cart: " . $stmt->error;
            }
        } else {
            echo "Food item not found.";
        }
    } else {
        echo "User not logged in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu</title>
    <link rel="stylesheet" href="../assets/css/cus food.css">
</head>
<body>
    <div class="menu-container">
        <a href="../customer.php" class="back-button">Back</a>

        <h1>Gallery Cafe Food Menu</h1>
 
        <form class="filter-form" method="POST" action="">
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php while ($row = $categoriesResult->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['name']); ?>" <?php echo $selectedCategory == $row['name'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
        <div class="food-items-container">
            <?php if (!empty($foodItems)): ?>
                <?php foreach ($foodItems as $food): ?>
                    <div class="food-item">
                        <img src="../uploads/<?php echo htmlspecialchars($food['image']); ?>" alt="Food Image">
                        <div class="food-item-details">
                            <span class="category"><?php echo htmlspecialchars($food['category']); ?></span>
                            <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                            <p class="price">LKR. <?php echo htmlspecialchars($food['price']); ?></p>
                            <form action="" method="post">
                                <input type="hidden" name="food_item_id" value="<?php echo htmlspecialchars($food['id']); ?>">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1">
                                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
             
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No food items found.</p>
            <?php endif; ?>
        </div>
    <a href="cart.php?id=<?php echo htmlspecialchars($food['id']); ?>" class="order-now-btn">CheckOut</a>
    <a href="preoder cart.php?id=<?php echo htmlspecialchars($food['id']); ?>" class="order-now-btn">Pre-Oders</a>
    </div>   
</body>
</html>
<?php
$conn->close();
?>
