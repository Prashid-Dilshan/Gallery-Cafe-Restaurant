<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_cafe";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$foodMessage = '';
$addCategoryMessage = '';
$deleteCategoryMessage = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $newCategory = $_POST['new_category'];
    if (!empty($newCategory)) {

        $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->bind_param("s", $newCategory);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $addCategoryMessage = "Category already exists.";
        } else {

            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->bind_param("s", $newCategory);
            if ($stmt->execute()) {
                $addCategoryMessage = "New category added successfully!";
            } else {
                $addCategoryMessage = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}


if (isset($_POST['delete_category'])) {
    $categoryToDelete = $_POST['category_to_delete'];
    if (!empty($categoryToDelete)) {
        
                $stmt = $conn->prepare("SELECT id FROM food_items WHERE category = ?");
        $stmt->bind_param("s", $categoryToDelete);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $deleteCategoryMessage = "Cannot delete category, it is used in food items.";
        } else {
           
            $stmt->close();
            $stmt = $conn->prepare("DELETE FROM categories WHERE name = ?");
            $stmt->bind_param("s", $categoryToDelete);
            if ($stmt->execute()) {
                $deleteCategoryMessage = "Category deleted successfully!";
            } else {
                $deleteCategoryMessage = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}


if (isset($_POST['add_food'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExtension, $allowedExtensions) && $imageSize < 5000000) {
            $newImageName = uniqid('', true) . "." . $imageExtension;
            $imageDestination = __DIR__ . '/../uploads/' . $newImageName;

            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                $stmt = $conn->prepare("INSERT INTO food_items (name, category, image, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssd", $name, $category, $newImageName, $price);

                if ($stmt->execute()) {
                    $foodMessage = "New food item added successfully!";
                } else {
                    $foodMessage = "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $foodMessage = "Failed to upload image.";
            }
        } else {
            $foodMessage = "Invalid file type or size.";
        }
    } else {
        $foodMessage = "No file uploaded or upload error.";
    }
}


if (isset($_POST['delete_food'])) {
    $food_id = $_POST['food_id'];

    $stmt = $conn->prepare("SELECT image FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $food = $result->fetch_assoc();
    $imageToDelete = $food['image'];
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    if ($stmt->execute()) {
        if ($imageToDelete && file_exists(__DIR__ . '/../uploads/' . $imageToDelete)) {
            unlink(__DIR__ . '/../uploads/' . $imageToDelete);
        }
        $foodMessage = "Food item deleted successfully!";
    } else {
        $foodMessage = "Error: " . $stmt->error;
    }
    $stmt->close();
}


$categoriesSql = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesSql);


$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item</title>
    <link rel="stylesheet" href="../assets/css/Add food.css">
</head>
<body>
    <div class="container">

    <!-- Form for adding a new food item -->
    <form action="add food.php" method="POST" enctype="multipart/form-data">
        <h1>Add Food Item</h1>

        <?php if (!empty($foodMessage)): ?>
            <p class="message <?php echo strpos($foodMessage, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($foodMessage); ?>
            </p>
        <?php endif; ?>

        <label for="name">Food Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <?php while ($row = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['name']); ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br>

        <input type="hidden" name="add_food">
        <input type="submit" value="Add Food Item">
    </form>


    <!-- Form for adding a new category -->
    <form action="add food.php" method="POST">
        <h2>Add New Category</h2>

        <?php if (!empty($addCategoryMessage)): ?>
            <p class="message <?php echo strpos($addCategoryMessage, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($addCategoryMessage); ?>
            </p>
        <?php endif; ?>

        <label for="new_category">New Category Name:</label>
        <input type="text" id="new_category" name="new_category" required><br>
        <input type="hidden" name="add_category">
        <input type="submit" value="Add Category">
    </form>


    <!-- Form for Delete category -->
    <form action="add food.php" method="POST">
        <h2>Delete Category</h2>

        <?php if (!empty($deleteCategoryMessage)): ?>
            <p class="message <?php echo strpos($deleteCategoryMessage, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($deleteCategoryMessage); ?>
            </p>
        <?php endif; ?>

        <label for="category_to_delete">Select Category to Delete:</label>
        <select id="category_to_delete" name="category_to_delete" required>
            <?php

            
            $categoriesResult->data_seek(0);
            while ($row = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['name']); ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <input type="hidden" name="delete_category">
        <input type="submit" value="Delete Category">
    </form>

    <h2>Existing Food Items</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Food Image" width="100"></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td>
                            <form action="add food.php" method="POST" style="display:inline;">
                                <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="delete_food">
                                <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No food items found.</p>
    <?php endif; ?>

    <?php

    $conn->close();
    ?>
    </div>
</body>
</html>


