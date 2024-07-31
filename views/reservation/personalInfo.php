<?php
include '../../templates/header.php';
?>

<div class="container mt-5">
    <h2>Enter Personal Information</h2>
    <form action="../../handlers/guestInfoHandler.php" method="post">
        <div class="form-group">
            <label for="nic">NIC:</label>
            <input type="text" name="nic" id="nic" class="form-control" required>
            <span id="nic-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
            <span id="first-name-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
            <span id="last-name-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
            <span id="contact-number-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
            <span id="email-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address:</label>
            <textarea name="home_address" id="home_address" class="form-control" required></textarea>
            <span id="home-address-error" style="color: red; font-size: 12px;"></span>
        </div>
        <!-- <button type="submit" class="btn btn-primary">Set Username and Password</button> -->
        <button type="submit" class="btn btn-primary">Proceed with Payment</button>
    </form>
</div>

<!-- Form Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nic').on('input', function() {
            var nic = $(this).val();
            if (nic.length < 10 || nic.length > 12) {
                $('#nic-error').text('Invalid NIC number. It should be between 10 to 12 characters.');
            } else {
                $('#nic-error').text('');
            }
        });

        $('#first_name').on('input', function() {
            var firstName = $(this).val();
            if (!firstName.match(/^[a-zA-Z ]+$/)) {
                $('#first-name-error').text('Invalid first name. It should only contain letters and spaces.');
            } else {
                $('#first-name-error').text('');
            }
        });

        $('#last_name').on('input', function() {
            var lastName = $(this).val();
            if (!lastName.match(/^[a-zA-Z ]+$/)) {
                $('#last-name-error').text('Invalid last name. It should only contain letters and spaces.');
            } else {
                $('#last-name-error').text('');
            }
        });

        $('#contact_number').on('input', function() {
            var contactNumber = $(this).val();
            if (!contactNumber.match(/^\d{10}$/)) {
                $('#contact-number-error').text('Invalid contact number. It should be a 10-digit number.');
            } else {
                $('#contact-number-error').text('');
            }
        });

        $('#email').on('input', function() {
            var email = $(this).val();
            if (!email.match(/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,}$/)) {
                $('#email-error').text('Invalid email address.');
            } else {
                $('#email-error').text('');
            }
        });

        $('#home_address').on('input', function() {
            var homeAddress = $(this).val();
            if (homeAddress.length < 5) {
                $('#home-address-error').text('Invalid home address. It should be at least 5 characters.');
            } else {
                $('#home-address-error').text('');
            }
        });
    });
</script>

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
