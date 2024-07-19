<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$year = date("Y"); // Current year
$revenue = $reportController->getAnnualRoomRevenue($year);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Room Revenue Report</title>
</head>
<body>
    <h1>Annual Room Revenue for <?php echo $year; ?></h1>
    <p>Revenue: LKR <?php echo $revenue; ?></p>
</body>
</html>
