<?php
session_start();
include_once __DIR__.'/../config/database.php';
include_once __DIR__.'/../models/Guest.php';
include_once __DIR__.'/../models/BanquetHall.php';
include_once __DIR__.'/../models/BanquetHallReservation.php';
include_once '../controllers/GuestController.php';
include_once '../controllers/BanquetHallReservationController.php';

$database = new Database();
$db = $database->getConnection();

$guestController = new GuestController($db);
$banquetHallReservationController = new BanquetHallReservationController($db);

$guestData = [
    'nic' => $_POST['nic'],
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'contact_number' => $_POST['contact_number'],
    'email' => $_POST['email'],
    'home_address' => $_POST['home_address']
];

// Check if guest exists
$existingGuest = $guestController->getByNIC($guestData['nic']);

if ($existingGuest) {
    $guest_id = $existingGuest['id']; 
} else {
    $guestController->create($guestData);
    $newGuest = $guestController->getByNIC($guestData['nic']);
    if ($newGuest) {
        $guest_id = $newGuest['id'];
    } else {
        die('Error creating guest record.');
    }
}

// Debugging output
echo "Guest ID: $guest_id";

// Create banquet hall reservation
// $reservationData = [
//     'hall_id' => $_SESSION['hall_id'],
//     'guest_id' => $guest_id,
//     'event_date' => $_SESSION['event_date'],
//     'start_time' => $_SESSION['start_time'],
//     'end_time' => $_SESSION['end_time'],
//     'number_of_guests' => $_SESSION['number_of_guests'],
//     'status' => 'pending',
//     'total_charge' => calculateTotalCharge($_SESSION['hall_id'], $_SESSION['start_time'], $_SESSION['end_time'])
// ];

// $banquetHallReservationController->create($reservationData);

// // Clear session data
// session_unset();
// session_destroy();

// // Redirect to confirmation page
// header("Location: ../views/reservation/hallConfirmation.php?hall_id={$reservationData['hall_id']}&guest_id={$guest_id}&event_date={$reservationData['event_date']}&total_charge={$reservationData['total_charge']}");
// exit();

// Retrieving reservation details from session

// $guest_id = isset($_POST['guest_id']) ? $_POST['guest_id'] : '';
$date = $_POST['event_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$number_of_guests = $_POST['number_of_guests'];
$hall_id = $_POST['hall_id']; 

// $selected_slots = $_POST['time_slots'];

// // Define time slots and their ranges
// $time_slots = [
//     'morning' => ['start' => '04:00', 'end' => '12:00'],
//     'afternoon' => ['start' => '12:30', 'end' => '16:30'],
//     'evening' => ['start' => '17:00', 'end' => '00:00']
// ];

// // Validate that start and end times fall within the selected time slots
// function timeInRange($start, $end, $time) {
//     return ($time >= $start && $time <= $end);
// }

// $isValid = false;
// foreach ($selected_slots as $slot) {
//     if (!isset($time_slots[$slot])) {
//         die('Invalid time slot selected.');
//     }

//     $slot_start = $time_slots[$slot]['start'];
//     $slot_end = $time_slots[$slot]['end'];
    
//     if (timeInRange($slot_start, $slot_end, $start_time) && timeInRange($slot_start, $slot_end, $end_time)) {
//         $isValid = true;
//         break;
//     }
// }

// if (!$isValid) {
//     die('Selected times do not fall within the chosen time slots.');
// }

// Debugging output
echo "Event Date: $date, Start Time: $start_time, End Time: $end_time, Number of Guests: $number_of_guests, Hall ID: $hall_id";

$total_charge = calculateTotalCharge($hall_id, $start_time, $end_time);

$reservation = new BanquetHallReservation($db);
$reservation->guest_id = $guest_id;
$reservation->hall_id = $hall_id; 
$reservation->event_date = $date;
$reservation->start_time = $start_time;
$reservation->end_time = $end_time;
$reservation->number_of_guests = $number_of_guests;
$reservation->status = 'pending';
$reservation->total_charge = $total_charge;

// Debugging output
echo "Reservation Details: ", print_r($reservation, true);

$controller = new BanquetHallReservationController($db);
$result = $controller->create($reservation);

if ($result) {
    header('Location: ../views/reservation/hallConfirmation.php?hall_id=' . $reservation->hall_id . '&guest_id=' . $reservation->guest_id . '&event_date=' . $reservation->event_date . '&total_charge=' . $reservation->total_charge);
   // header("Location: ../views/reservation/hallConfirmation.php?hall_id={$reservation->hall_id}&guest_id={$reservation->guest_id}&event_date={$reservation->event_date}&total_charge={$reservation->total_charge}");
} else {
    header('Location: ../views/dashboard/customerDashboard.php');
}

function calculateTotalCharge($hall_id, $start_time, $end_time) {
    // Fetch hall charge per hour from BanquetHall model
    $banquetHall = new BanquetHall($GLOBALS['db']);
    $banquetHall->hall_id = $hall_id;
    $banquetHall->readOne();

    $charge_per_hour = $banquetHall->charge_per_hour;
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $duration = $start->diff($end);
    $hours = $duration->h + ($duration->i / 60);

    return $hours * $charge_per_hour;
}
?>
