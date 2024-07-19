<?php
session_start();
include_once '../config/database.php';
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
    $guest_id = $newGuest['id'];
}

// Create banquet hall reservation
$reservationData = [
    'hall_id' => $_SESSION['hall_id'],
    'guest_id' => $guest_id,
    'event_date' => $_SESSION['event_date'],
    'start_time' => $_SESSION['start_time'],
    'end_time' => $_SESSION['end_time'],
    'number_of_guests' => $_SESSION['number_of_guests'],
    'status' => 'pending',
    'total_charge' => calculateTotalCharge($_SESSION['hall_id'], $_SESSION['start_time'], $_SESSION['end_time'])
];

$banquetHallReservationController->create($reservationData);

// Clear session data
session_unset();
session_destroy();

// Redirect to confirmation page
header("Location: ../views/reservation/hallConfirmation.php?hall_id={$reservationData['hall_id']}&guest_id={$guest_id}&event_date={$reservationData['event_date']}&total_charge={$reservationData['total_charge']}");
exit();

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
