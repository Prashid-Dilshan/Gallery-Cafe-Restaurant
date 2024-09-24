

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_cafe";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/Food.css">
    <title>Our Menu</title>
</head>
<body>
    <div class="menu-container">
    <a href="index.php" class="back-button"><button>Back</button></a>

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
                    <p class="price">LKR.<?php echo htmlspecialchars($food['price']); ?></p>
                    <a href="login.php" class="order-now-btn">Order Now</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No food items found.</p>
    <?php endif; ?>
</div>

</body>
</html>
