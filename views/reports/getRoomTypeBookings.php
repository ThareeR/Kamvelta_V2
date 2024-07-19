<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$data = $reportController->getRoomTypeBookings();
echo json_encode($data);
?>
