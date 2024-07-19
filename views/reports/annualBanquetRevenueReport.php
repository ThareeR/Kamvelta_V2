<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$year = date("Y"); // Current year
$annualRevenues = $reportController->getAnnualBanquetRevenueForYear($year);
$totalRevenue = 0;
$hallRevenues = [];

foreach ($annualRevenues as $revenue) {
    $totalRevenue += $revenue['revenue'];
    $hallRevenues[$revenue['hall_name']] = $revenue['revenue'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Banquet Hall Revenue Report</title>
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
    <h1>Annual Banquet Hall Revenue for <?php echo $year; ?></h1>
    <table>
        <tr>
            <th>Banquet Hall</th>
            <th>Revenue (LKR)</th>
        </tr>
        <tr>
            <td>Total Revenue</td>
            <td><?php echo number_format($totalRevenue, 2); ?></td>
        </tr>
        <?php foreach ($hallRevenues as $hallName => $revenue): ?>
            <tr>
                <td><?php echo htmlspecialchars($hallName); ?></td>
                <td><?php echo number_format($revenue, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

