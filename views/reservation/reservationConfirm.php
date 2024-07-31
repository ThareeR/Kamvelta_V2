<?php
session_start();
include '../../templates/header.php';

if (!isset($_SESSION['reservation_id'])) {
    echo "No reservation found.";
    exit;
}

$reservationId = $_SESSION['reservation_id'];
$guestEmail = $_SESSION['guest_email'];
$guestFirstName = $_SESSION['guest_first_name'];
$guestLastName = $_SESSION['guest_last_name'];
$checkInDate = $_SESSION['check_in_date'];
$checkOutDate = $_SESSION['check_out_date'];
$totalCharge = $_SESSION['total_charge'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
</head>
<body>
    <h1>Reservation Confirmation</h1>
    <p>Dear <?php echo htmlspecialchars($guestFirstName . ' ' . $guestLastName); ?>,</p>
    <p>Thank you for your reservation. Your reservation ID is <?php echo htmlspecialchars($reservationId); ?>.</p>
    <p>Check-in Date: <?php echo htmlspecialchars($checkInDate); ?></p>
    <p>Check-out Date: <?php echo htmlspecialchars($checkOutDate); ?></p>
    <p>Total Charge: <?php echo htmlspecialchars($totalCharge); ?></p>
    <p>We look forward to your stay.</p>
    <p>We have sent a confirmation email to <?php echo htmlspecialchars($guestEmail); ?>.</p>
</body>
</html>

<?php
// Clear session data after displaying the confirmation
session_unset();
session_destroy();
?>



<?php
// include '../../templates/header.php';

// if (isset($_SESSION['reservation_id'])) {
//     echo "<div class='container mt-5'><h2>Reservation Confirmed</h2><p>Your reservation ID is " . $_SESSION['reservation_id'] . "</p></div>";
// } else {
//     echo "<div class='container mt-5'><h2>Reservation Failed</h2><p>Please try again.</p></div>";
// }

// include '../../templates/footer.php';

?>

<?php
// session_start();

// if (!isset($_SESSION['user_id']) || !isset($_SESSION['personal_info'])) {
//     header('Location: selectRooms.php');
//     exit;
// }

// include '../../config/database.php';
// include '../../controllers/ReservationController.php';
// include '../../controllers/GuestController.php';

// $database = new Database();
// $db = $database->getConnection();
// $reservationController = new ReservationController($db);
// $guestController = new GuestController($db);

// $user_id = $_SESSION['user_id'];
// $check_in = $_SESSION['check_in'];
// $check_out = $_SESSION['check_out'];
// $room_selections = $_SESSION['room_selections'];
// $personal_info = $_SESSION['personal_info'];

// $guest_id = $guestController->getGuestIDByNIC($personal_info['nic']);
// if (!$guest_id) {
//     $guest_id = $guestController->createGuest($personal_info);
// }

// $total_charge = 0;
// $room_prices = [
//     'single' => 100, // Replace with actual room prices from the database
//     'double' => 150,
//     'triple' => 200
// ];
// foreach ($room_selections as $room_type => $count) {
//     $total_charge += $count * $room_prices[$room_type];
// }

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $payment_method = $_POST['payment_method'];

//     $reservation_id = $reservationController->createReservation([
//         'guest_id' => $guest_id,
//         'check_in' => $check_in,
//         'check_out' => $check_out,
//         'total_charge' => $total_charge,
//         'status' => 'confirmed'
//     ]);

//     foreach ($room_selections as $room_type => $count) {
//         $reservationController->createReservationItem([
//             'reservation_id' => $reservation_id,
//             'room_type_id' => $room_type, // Convert room type to id
//             'room_count' => $count,
//             'rate_per_unit' => $room_prices[$room_type],
//             'total_charge' => $count * $room_prices[$room_type]
//         ]);
//     }

//     header('Location: confirmation.php');
//     exit;
// }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Confirmation</title>
</head>
<body>
    <h1>Confirm Your Reservation</h1>
    <form method="POST" action="">
        <label for="payment_method">Select Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="online">Online</option>
            <option value="credit_card">Credit/Debit Card</option>
            <option value="on_site">On-site</option>
        </select>
        
        <button type="submit">Confirm Reservation</button>
    </form>
</body>
</html> -->
