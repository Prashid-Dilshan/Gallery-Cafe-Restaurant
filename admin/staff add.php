<?php
include '../db.php';

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Add staff
if (isset($_POST['add_staff'])) {
    $email = sanitizeInput($_POST['email']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT);
    $address = sanitizeInput($_POST['address']);
    $mobile_number = sanitizeInput($_POST['mobile_number']);
    $staff_id_number = sanitizeInput($_POST['staff_id_number']);


    // Check if email or staff_id_number already exists
    $check_stmt = $conn->prepare("SELECT id FROM staff_details WHERE email = ? OR staff_id_number = ?");
    $check_stmt->bind_param("ss", $email, $staff_id_number);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "<div class='message error'>Error: Email or Staff ID number already exists.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO staff_details (email, password, address, mobile_number, staff_id_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $password, $address, $mobile_number, $staff_id_number);

        if ($stmt->execute()) {
            $message = "<div class='message success'>New staff added successfully.</div>";
        } else {
            $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}

// Update staff
if (isset($_POST['update_staff'])) {
    $id = sanitizeInput($_POST['id']);
    $email = sanitizeInput($_POST['email']);
    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT);
    $address = sanitizeInput($_POST['address']);
    $mobile_number = sanitizeInput($_POST['mobile_number']);
    $staff_id_number = sanitizeInput($_POST['staff_id_number']);

    
    // Check if staff_id_number exists for another record
    $check_stmt = $conn->prepare("SELECT id FROM staff_details WHERE staff_id_number = ? AND id != ?");
    $check_stmt->bind_param("si", $staff_id_number, $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "<div class='message error'>Error: Staff ID number already exists for another staff.</div>";
    } else {
        $stmt = $conn->prepare("UPDATE staff_details SET email = ?, password = ?, address = ?, mobile_number = ?, staff_id_number = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $email, $password, $address, $mobile_number, $staff_id_number, $id);

        if ($stmt->execute()) {
            $message = "<div class='message success'>Staff updated successfully.</div>";
        } else {
            $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}

// Delete staff
if (isset($_POST['delete_staff'])) {
    $id = sanitizeInput($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM staff_details WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "<div class='message success'>Staff deleted successfully.</div>";
    } else {
        $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Staff</title>
    <link rel="stylesheet" href="../assets/css/staff add.css">
</head>
<body>

<div class="container">
    <h1>Add New Staff</h1>
    <?php if (isset($message)) echo $message; ?>
    <div class="form-container">
        <form method="post" action="">
            <p>Staff Email:</p>
            <input type="email" name="email" placeholder="Email" required>

            <p>Staff Password:</p>
            <input type="password" name="password" placeholder="Password" required>

            <p>Staff Address:</p>
            <input type="text" name="address" placeholder="Address" required>

            <p>Staff Mobile Number:</p>
            <input type="text" name="mobile_number" placeholder="Mobile Number" required>

            <p>Staff ID Number:</p>
            <input type="text" name="staff_id_number" placeholder="Staff ID Number" required>

            <button type="submit" name="add_staff">Add Staff</button>
        </form>
    </div>

    <h2>Existing Staff</h2>
    <div class="staff-list">
        <?php
        $result = $conn->query("SELECT * FROM staff_details");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='staff-item'>";
                echo "<form method='post' action=''>";
                echo "<p>Email: " . $row['email'] . "</p>";
                echo "<p>Address: " . $row['address'] . "</p>";
                echo "<p>Mobile Number: " . $row['mobile_number'] . "</p>";
                echo "<p>Staff ID Number: " . $row['staff_id_number'] . "</p>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";

                echo "<input type='email' name='email' value='" . $row['email'] . "' required>";
                echo "<input type='password' name='password' placeholder='New Password'>";
                echo "<input type='text' name='address' value='" . $row['address'] . "' required>";
                echo "<input type='text' name='mobile_number' value='" . $row['mobile_number'] . "' required>";
                echo "<input type='text' name='staff_id_number' value='" . $row['staff_id_number'] . "' required>";
                echo "<button type='submit' name='update_staff'>Update</button>";
                echo "<button type='submit' name='delete_staff'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No staff found.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
