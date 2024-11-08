<?php
session_start();
include '../config/database.php';
include '../controllers/ReservationController.php';

$database = new Database();
$db = $database->getConnection();
$reservationController = new ReservationController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['check_in_date']) && isset($_POST['check_out_date'])) {
        $checkInDate = $_POST['check_in_date'];
        $checkOutDate = $_POST['check_out_date'];

        $availableRooms = $reservationController->checkAvailability($checkInDate, $checkOutDate);

        $_SESSION['check_in_date'] = $checkInDate;
        $_SESSION['check_out_date'] = $checkOutDate;
        $_SESSION['available_rooms'] = $availableRooms;

        header('Location: ../views/reservation/selectRooms.php');
    } 
    
    if (isset($_POST['room_count'])) {
        $roomCounts = $_POST['room_count'];
        $roomTypeIds = $_POST['room_type_id'];
        $ratePerUnits = $_POST['rate_per_unit'];
        $reservationItems = [];
        $totalAmount = 0;

        for ($i = 0; $i < count($roomCounts); $i++) {
            if ($roomCounts[$i] > 0) {
                $item = [
                    'room_type_id' => $roomTypeIds[$i],
                    'room_count' => $roomCounts[$i],
                    'rate_per_unit' => $ratePerUnits[$i],
                    'total_charge' => $roomCounts[$i] * $ratePerUnits[$i]
                ];
                $totalAmount += $item['total_charge'];
                array_push($reservationItems, $item);
            }
        }

        $_SESSION['reservation_items'] = $reservationItems;
        $_SESSION['total_charge'] = $totalAmount;

        header('Location: ../views/reservation/personalInfo.php');
    }
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 
'delete') {
  $reservationId = $_GET['id'];
  if ($reservationController->delete($reservationId)) {
    header("Location: ../views/dashboard/manageReservations.php");
  } else {
    echo "Error deleting reservation.";
  }
} elseif (isset($_POST['id']) && isset($_POST['guest_id']) && 
isset($_POST['check_in_date']) && isset($_POST['check_out_date']) && isset($_POST['reservation_status'])) {
  $reservationId = $_POST['id'];
  $reservationData = [
    'guest_id' => $_POST['guest_id'],
    'check_in_date' => $_POST['check_in_date'],
    'check_out_date' => $_POST['check_out_date'],
    'reservation_status' => $_POST['reservation_status']
  ];
  if ($reservationController->update($reservationId, $reservationData)) {
    header("Location: ../views/dashboard/manageReservations.php");
  } else {
    echo "Error updating reservation.";
  }
}

?>
