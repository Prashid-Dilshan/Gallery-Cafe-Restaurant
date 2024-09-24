


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="../assets/css/Admin.css">
</head>
<body>

<h2>Admin Interface</h2>

<div class="navbar">
    <a href="javascript:void(0);" onclick="showSection('cus-details')">Customer Details</a>
    <a href="javascript:void(0);" onclick="showSection('update-baner')">Update Banner</a>
    <a href="javascript:void(0);" onclick="showSection('add-food')">Add Food</a>
    <a href="javascript:void(0);" onclick="showSection('order-details')">Order Details</a>
    <a href="javascript:void(0);" onclick="showSection('preorder-details')">Pre-Order Details</a>
    <a href="javascript:void(0);" onclick="showSection('customer-reservation-details')">Customer Reservation Details</a>
    <a href="javascript:void(0);" onclick="showSection('park-reservation')">Park Reservation</a>
    <a href="javascript:void(0);" onclick="showSection('staff-add')">Staff Add</a>
</div>

<div class="main-content">
    <div id="cus-details" class="iframe-container">
        <iframe src="cus-details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="update-baner" class="iframe-container">
        <iframe src="update baner.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="add-food" class="iframe-container">
        <iframe src="add food.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="order-details" class="iframe-container">
        <iframe src="oder details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="preorder-details" class="iframe-container">
        <iframe src="preoder details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>


    <div id="customer-reservation-details" class="iframe-container">
        <iframe src="Customer reservation details.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="park-reservation" class="iframe-container">
        <iframe src="park reservation.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>

    <div id="staff-add" class="iframe-container">
        <iframe src="staff add.php" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>
    </div>
</div>

<script>
    showSection('cus-details');


        function showSection(sectionId) {
            
            var sections = document.getElementsByClassName('iframe-container');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }           
            document.getElementById(sectionId).classList.add('active');
        }
 


</script>

</body>
</html>
