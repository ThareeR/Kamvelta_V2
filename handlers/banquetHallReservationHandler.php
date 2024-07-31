<?php

session_start();
include_once '../config/database.php';
include_once '../controllers/BanquetHallReservationController.php';
include_once '../controllers/BanquetHallController.php';

$database = new Database();
$db = $database->getConnection();
$reservationController = new BanquetHallReservationController($db);
$hallController = new BanquetHallController($db);

$hall_id = $_POST['hall_id'];
$event_date = $_POST['event_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$number_of_guests = $_POST['number_of_guests'];

// Check if hall is available
// if (!$reservationController->isHallAvailable($hall_id, $event_date)) {
//     $_SESSION['error'] = "Hall is unavailable on the selected date.";

//    echo '<script>
//     alert("Hall is unavailable on the selected date.");
//     window.location.href = "../views/reservation/banquetHallReservationForm.php?hall_id='. $hall_id . '";
//     </script>';

//     // header("Location: ../views/reservation/banquetHallReservationForm.php?hall_id=$hall_id");
//     exit();
// }

// Debugging print statements
// echo "hall_id: " . $hall_id . "<br>";
// echo "event_date: " . $event_date . "<br>";
// echo "start_time: " . $start_time . "<br>";
// echo "end_time: " . $end_time . "<br>";
// echo "number_of_guests: " . $number_of_guests . "<br>";

// Store data in session
$_SESSION['hall_id'] = $hall_id;
$_SESSION['event_date'] = $event_date;
$_SESSION['start_time'] = $start_time;
$_SESSION['end_time'] = $end_time;
$_SESSION['number_of_guests'] = $number_of_guests;
$_SESSION['status'] = 'pending';

header("Location: ../views/reservation/personalInfoForm.php");
exit();
?>

<?php
// session_start();

// $_SESSION['hall_id'] = $_POST['hall_id'];
// $_SESSION['event_date'] = $_POST['event_date'];
// $_SESSION['start_time'] = $_POST['start_time'];
// $_SESSION['end_time'] = $_POST['end_time'];
// $_SESSION['number_of_guests'] = $_POST['number_of_guests'];

// header("Location: ../views/reservation/personalInfoForm.php");

// include '../config/database.php';
// include '../controllers/BanquetHallReservationController.php';

// $database = new Database();
// $db = $database->getConnection();
// $controller = new BanquetHallReservationController($db);

// if ($_POST) {
//     $data = [
//         'guest_id' => $_POST['guest_id'],
//         'hall_id' => $_POST['hall_id'],
//         'event_date' => $_POST['event_date'],
//         'start_time' => $_POST['start_time'],
//         'end_time' => $_POST['end_time'],
//         'number_of_guests' => $_POST['number_of_guests'],
//         'status' => 'pending'
//     ];

//     if ($controller->create($data)) {
//         header("Location: ../views/reservation/banquetHallReservationsList.php");
//     } else {
//         echo "Error creating reservation.";
//     }
// }
?>
