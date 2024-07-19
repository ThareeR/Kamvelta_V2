<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$year = date("Y"); // Current year
$month = date("m"); // Current month
$income = $reportController->getMonthlyRoomRevenue($year, $month);

$monthlyRevenue = $reportController->getMonthlyRoomRevenueForYear($year);
$months = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$revenueData = array_fill(1, 12, 0); // Initialize all months with zero revenue

foreach ($monthlyRevenue as $revenue) {
    $revenueData[$revenue['month']] = $revenue['revenue'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Room Revenue Report</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Monthly Room Revenue for <?php echo date("F", mktime(0, 0, 0, $month, 10)) . ", " . $year; ?></h2>
    <p>Revenue: LKR <?php echo $income; ?></p>

    <!-- Displays the income for each month -->

    <h2>Monthly Room Revenue for <?php echo $year; ?></h2>
    <table>
        <tr>
            <th>Month</th>
            <th>Revenue (LKR)</th>
        </tr>
        <?php foreach ($months as $monthNumber => $monthName): ?>
            <tr>
                <td><?php echo $monthName; ?></td>
                <td><?php echo number_format($revenueData[$monthNumber], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
