<?php
include_once '../../config/database.php';
include_once '../../controllers/ReportController.php';

$database = new Database();
$db = $database->getConnection();
$reportController = new ReportController($db);

$year = date("Y"); // Current year
$monthlyRevenues = $reportController->getMonthlyBanquetRevenueForYear($year);
$months = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$hall1Revenues = array_fill(1, 12, 0);
$hall2Revenues = array_fill(1, 12, 0);

foreach ($monthlyRevenues as $revenue) {
    if ($revenue['hall_id'] == 1) {
        $hall1Revenues[$revenue['month']] = $revenue['revenue'];
    } elseif ($revenue['hall_id'] == 2) {
        $hall2Revenues[$revenue['month']] = $revenue['revenue'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Banquet Hall Revenue Report</title>
    <style>
        table {
            /* width: 45%; */
            border-collapse: collapse;
            margin: 20px 2.5%;
            display: inline-block;
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
    <div class="container-fluid">
        <h1>Monthly Banquet Hall Revenue for <?php echo $year; ?></h1>
        <div class="row">
        <div class="col-md-4">
            <h2>Bamboo Ballroom</h2>
            <table>
                <tr>
                    <th>Month</th>
                    <th>Revenue (LKR)</th>
                </tr>
                <?php foreach ($months as $monthNumber => $monthName): ?>
                    <tr>
                        <td><?php echo $monthName; ?></td>
                        <td><?php echo number_format($hall1Revenues[$monthNumber], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="col-md-4">
            <h2>Nature Top Hall</h2>
            <table>
                <tr>
                    <th>Month</th>
                    <th>Revenue (LKR)</th>
                </tr>
                <?php foreach ($months as $monthNumber => $monthName): ?>
                    <tr>
                        <td><?php echo $monthName; ?></td>
                        <td><?php echo number_format($hall2Revenues[$monthNumber], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        </div>
    </div>
</body>
</html>

