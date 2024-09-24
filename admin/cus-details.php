<?php
include '../db.php';


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $emailToDelete = $_POST['email'];


    $deleteSql = "DELETE FROM users WHERE email = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("s", $emailToDelete);

    if ($stmt->execute()) {
        $success = "User deleted successfully.";
    } else {
        $error = "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
}


$sql = "SELECT email, password FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Customer Details - Gallery Cafe</title>
    <link rel="stylesheet" href="../assets/css/cus-details.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Customer Account Details</h1>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                        echo '<td>
                                <form method="POST" action="">
                                    <input type="hidden" name="email" value="' . htmlspecialchars($row['email']) . '">
                                    <button type="submit" name="delete">Delete</button>
                                </form>
                              </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>

<?php
$conn->close();
?>
