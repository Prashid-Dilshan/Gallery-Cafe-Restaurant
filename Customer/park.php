<?php
session_start();
include('../db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; 
    if ($user_id === null) {
        die("User not logged in.");
    }

    $selected_spots = explode(',', $_POST['selected_spots']);
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $duration = $_POST['duration'];
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];

  
    $query = "INSERT INTO parking_reservations (user_id, spot_id, reservation_date, reservation_time, duration, fullname, phone_number) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
   
    foreach ($selected_spots as $spot) {
        $spot_id = (int) substr($spot, 4); 
        
        $stmt->bind_param("iississ", $user_id, $spot_id, $reservation_date, $reservation_time, $duration, $fullname, $phone_number);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    }


    header("Location: ./comfirmation.php");
    exit();
}


$reserved_spots = [];
if (isset($_GET['date'])) {
    $reservation_date = $_GET['date'];


    $query = "SELECT spot_id FROM parking_reservations WHERE reservation_date = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("s", $reservation_date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $reserved_spots[] = $row['spot_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Reservation</title>
    <link rel="stylesheet" href="../assets/css/park.css">
</head>
<body>
    <h2>Reserve Parking Spots</h2>

    <div class="parking-area">

        <div class="parking-spot" id="spot1">1</div>
        <div class="parking-spot" id="spot2">2</div>
        <div class="parking-spot" id="spot3">3</div>
        <div class="parking-spot" id="spot4">4</div>
        <div class="parking-spot" id="spot5">5</div>
        <div class="parking-spot" id="spot6">6</div>
        <div class="parking-spot" id="spot7">7</div>
        <div class="parking-spot" id="spot8">8</div>
        <div class="parking-spot" id="spot9">9</div>
        <div class="parking-spot" id="spot10">10</div>
        <div class="parking-spot" id="spot11">11</div>
        <div class="parking-spot" id="spot12">12</div>
        <div class="parking-spot" id="spot13">13</div>
        <div class="parking-spot" id="spot14">14</div>
        <div class="parking-spot" id="spot15">15</div>
        <div class="parking-spot" id="spot16">16</div>
    </div>

    <form id="reservation-form" action="park.php" method="post">
        <input type="hidden" id="selected_spots" name="selected_spots" required>
        
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number" required><br><br>

        <label for="reservation_date">Date of Reservation:</label><br>
        <input type="date" id="reservation_date" name="reservation_date" required><br><br>

        <label for="reservation_time">Time of Reservation:</label><br>
        <input type="time" id="reservation_time" name="reservation_time" required><br><br>

        <label for="duration">Duration (in hours):</label><br>
        <input type="number" id="duration" name="duration" min="1" required><br><br>
<button type="submit" id="submit-button">Submit Reservation</button>
    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const spots = document.querySelectorAll(".parking-spot");
            const selectedSpotsInput = document.getElementById("selected_spots");
            const reservationForm = document.getElementById("reservation-form");
            const reservationDateInput = document.getElementById("reservation_date");
    
            const savedSelectedSpots = localStorage.getItem("selectedSpots");
            if (savedSelectedSpots) {
                const selectedSpots = JSON.parse(savedSelectedSpots);
                selectedSpots.forEach(spotId => {
                    const spot = document.getElementById(spotId);
                    if (spot && !spot.classList.contains("reserved")) {
                        spot.classList.add("selected");
                    }
                });
                updateSelectedSpots();
            }

            reservationDateInput.addEventListener("change", function() {
                fetchReservedSpots(this.value);
            });

            function fetchReservedSpots(date) {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `park.php?date=${date}`, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const reservedSpots = JSON.parse(xhr.responseText);
                        spots.forEach(spot => {
                            spot.classList.remove("reserved");
                        });
                        reservedSpots.forEach(spot_id => {
                            const spot = document.getElementById(`spot${spot_id}`);
                            if (spot) {
                                spot.classList.add("reserved");
                            }
                        });
                    } else {
                        console.error("Failed to fetch reserved spots.");
                    }
                };
                xhr.send();
            }

            spots.forEach(spot => {
                spot.addEventListener("click", function() {
                    if (!this.classList.contains("reserved")) {
                        this.classList.toggle("selected");
                        updateSelectedSpots();
                    }
                });
            });

            function updateSelectedSpots() {
                const selectedSpots = getSelectedSpots();
                selectedSpotsInput.value = selectedSpots.join(",");
                localStorage.setItem("selectedSpots", JSON.stringify(selectedSpots));
            }

            function getSelectedSpots() {
                const selectedSpots = [];
                spots.forEach(spot => {
                    if (spot.classList.contains("selected")) {
                        selectedSpots.push(spot.id);
                    }
                });
                return selectedSpots;
            }

            reservationForm.addEventListener("submit", function(event) {
                event.preventDefault(); 
                this.submit(); 
            });
        });
    </script>

</body>
</html>

