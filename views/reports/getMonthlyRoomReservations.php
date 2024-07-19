<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$year = date("Y"); // Current year
$monthlyReservations = $reportController->getMonthlyRoomReservationsForYear($year);
echo json_encode($monthlyReservations);
?>
