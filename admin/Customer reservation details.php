<?php

include('../db.php');


$success_message = "";


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM reservations WHERE id = $id";
    if (mysqli_query($conn, $delete_sql)) {
        $success_message = "Reservation deleted successfully.";
    } else {
        echo "<script>alert('Error deleting reservation');</script>";
    }
}


$sql = "SELECT * FROM reservations";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reservations</title>
    <link rel="stylesheet" href="../assets/css/Customer reservation details.css">
</head>
<body>
    <div class="container">
        <form action="">
            <h1>Customer Reservations</h1>

            <!-- Display the success message if a reservation was deleted -->
            <?php if ($success_message): ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Table Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['time']}</td>
                                <td>{$row['guests']}</td>
                                <td>{$row['table_number']}</td>
                                <td><a href='Customer reservation details.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this reservation?');\">Delete</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No reservations found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
