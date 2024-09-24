



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Interface</title>
    <link rel="stylesheet" href="../assets/css/staff.css">
    
    <script>
        function showSection(sectionId) {

            var sections = document.getElementsByClassName('iframe-container');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }


            document.getElementById(sectionId).classList.add('active');
        }
    </script>
</head>
<body>

<h2>Admin Interface</h2>

<div class="navbar">
    <a href="javascript:void(0);" onclick="showSection('cus-details')">Customer Details</a>
    <a href="javascript:void(0);" onclick="showSection('order-details')">Order Details</a>
    <a href="javascript:void(0);" onclick="showSection('preorder-details')">Pre-Order Details</a>
    <a href="javascript:void(0);" onclick="showSection('customer-reservation-details')">Customer Reservation Details</a>
    <a href="javascript:void(0);" onclick="showSection('park-reservation')">Park Reservation</a>
    <a href="staff login.php" id="staff-lg"> Log Out</a>

</div>

<div class="main-content">

    <div id="cus-details" class="iframe-container">
        <iframe src="../admin/cus-details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="order-details" class="iframe-container">
        <iframe src="../admin/oder details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="preorder-details" class="iframe-container">
        <iframe src="../admin/preoder details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="customer-reservation-details" class="iframe-container">
        <iframe src="../admin/Customer reservation details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="park-reservation" class="iframe-container">
        <iframe src="../admin/park reservation.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

</div>

<script>
    showSection('cus-details');
</script>

</body>
</html>
