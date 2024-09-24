<?php
session_start();
include('../db.php'); 

// Fetch all parking reservations
$query = "SELECT * FROM parking_reservations";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . htmlspecialchars($conn->error));
}

// Handle deletion of a reservation
if (isset($_POST['delete'])) {
    $reservation_id = $_POST['reservation_id'];
    $delete_query = "DELETE FROM parking_reservations WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $reservation_id);
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    // Set success message in session
    $_SESSION['success_message'] = "Reservation deleted successfully.";

    // Redirect to refresh the page
    header("Location: park reservation.php");
    exit();
}

// Check for success message in session
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Parking Reservations</title>
    <link rel="stylesheet" href="../assets/css/admi park reservation details.css">
</head>
<body>
    <div class="container">
        <h1> Customer Parking Reservations</h1>

        <!-- Display success message -->
        <?php if ($success_message): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Spot ID</th>
                    <th>Reservation Date</th>
                    <th>Reservation Time</th>
                    <th>Duration</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['spot_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['reservation_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['duration']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td>
                            <form method="post" action="park reservation.php">
                                <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
