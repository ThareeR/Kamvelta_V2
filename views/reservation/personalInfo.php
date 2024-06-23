<?php
include '../../templates/header.php';
?>

<div class="container mt-5">
    <h2>Enter Personal Information</h2>
    <form action="../../handlers/reservationConfirm.php" method="post">
        <div class="form-group">
            <label for="nic">NIC:</label>
            <input type="text" name="nic" id="nic" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address:</label>
            <textarea name="home_address" id="home_address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Proceed with Payment</button>
    </form>
</div>

<?php
include '../../templates/footer.php';
?>

<!-- <?php
// session_start();

// if (!isset($_SESSION['user_id']) || !isset($_SESSION['room_selections'])) {
//     header('Location: selectRooms.php');
//     exit;
// }

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $first_name = $_POST['first_name'];
//     $last_name = $_POST['last_name'];
//     $nic = $_POST['nic'];
//     $contact_number = $_POST['contact_number'];
//     $email = $_POST['email'];
//     $home_address = $_POST['home_address'];

//     $_SESSION['personal_info'] = [
//         'first_name' => $first_name,
//         'last_name' => $last_name,
//         'nic' => $nic,
//         'contact_number' => $contact_number,
//         'email' => $email,
//         'home_address' => $home_address
//     ];

//     header('Location: reservationConfirm.php');
//     exit;
// }

// $room_selections = $_SESSION['room_selections'];
// $check_in = $_SESSION['check_in'];
// $check_out = $_SESSION['check_out'];

// // Calculate total charge
// $total_charge = 0;
// $room_prices = [
//     'single' => 2500, // Replace with actual room prices from the database
//     'double' => 3500,
//     'triple' => 4500
// ];
// foreach ($room_selections as $room_type => $count) {
//     $total_charge += $count * $room_prices[$room_type];
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personal Information</title>
</head>
<body>
    <h1>Enter Your Personal Information</h1>
    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        
        <label for="nic">NIC:</label>
        <input type="text" id="nic" name="nic" required>
        
        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="home_address">Home Address:</label>
        <input type="text" id="home_address" name="home_address" required>
        
        <h2>Total Charge: <?php echo $total_charge; ?></h2>
        
        <button type="submit">Proceed with Payment</button>
    </form>
</body>
</html>
 -->
