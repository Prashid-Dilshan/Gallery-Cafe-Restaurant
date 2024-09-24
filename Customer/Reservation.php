<?php
include('../db.php');
$reservation_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $guests = mysqli_real_escape_string($conn, $_POST['guests']);
    $table_number = mysqli_real_escape_string($conn, $_POST['table']);

    $sql = "INSERT INTO reservations (name, email, phone, date, time, guests, table_number) 
            VALUES ('$name', '$email', '$phone', '$date', '$time', '$guests', '$table_number')";

    if (mysqli_query($conn, $sql)) {
        $reservation_message = "Reservation successfully made! Redirecting to confirmation...";

        header("Location: reservation done.php?success=1&time=" . urlencode($time));
        exit();
    } else {
        $reservation_message = "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="../assets/css/Reservation.css">
</head>
<body>
    <div class="container">
        <h2>Reservation Form</h2>
        <div class="table-plan">
            <div class="table" data-table="Table 1">
                <span class="table-label">1</span>
            </div>
            <div class="table" data-table="Table 2">
                <span class="table-label">2</span>
            </div>
            <div class="table" data-table="Table 3">
                <span class="table-label">3</span>
            </div>
            <div class="table" data-table="Table 4">
                <span class="table-label">4</span>
            </div>
            <div class="table" data-table="Table 5">
                <span class="table-label">5</span>
            </div>
            <div class="table" data-table="Table 6">
                <span class="table-label">6</span>
            </div>
            <div class="table" data-table="Table 7">
                <span class="table-label">7</span>
            </div>
            <div class="table" data-table="Table 8">
                <span class="table-label">8</span>
            </div>
            <div class="table" data-table="Table 9">
                <span class="table-label">9</span>
            </div>
        </div>
        <form action="Reservation.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="guests">Number of Guests:</label>
                <input type="number" id="guests" name="guests" min="1" required>
            </div>
            <div class="form-group">
                <label for="selectedTable">Selected Table:</label>
                <input type="text" id="selectedTable" name="table" readonly required>
            </div>
            <input type="submit" value="Submit Reservation">
            <a href="../customer.php"><button type="button">Back</button></a>
        </form>
        <?php if ($reservation_message): ?>
            <div class="reservation-message"><?php echo $reservation_message; ?></div>
        <?php endif; ?>
    </div>

    <script>
        document.querySelectorAll('.table').forEach(table => {
            table.addEventListener('click', function() {
                document.querySelectorAll('.table').forEach(t => t.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selectedTable').value = this.getAttribute('data-table');
            });
        });
    </script>
</body>
</html>
