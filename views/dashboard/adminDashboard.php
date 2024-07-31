<?php
session_start();

include '../../templates/header.php'; 

include '../../config/database.php';
$database = new Database();
$db = $database->getConnection();

include_once '../../controllers/ReservationController.php';
$reservationController = new ReservationController($db);

include_once '../../controllers/PaymentController.php';
$paymentController = new PaymentController($db);

include_once '../../controllers/RoomTypeController.php';
$roomTypeController = new RoomTypeController($db);

include_once '../../controllers/GuestController.php';
$guestController = new GuestController($db);
?>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        button {
        display: block;
        margin-bottom: 10px; /* add some space between buttons */
    }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="sidebar">
                <ul>
                    <li><a href="#" class="active">Dashboard</a></li>
                    <li><a href="manageCustomers.php">Manage Customers</a></li>
                    <li><a href="manageReservations.php">Manage Reservations</a></li>
                    <li><a href="manageRooms.php">Manage Rooms</a></li>
                    <li><a href="manageBanquetHall.php">Manage Banquet Hall</a></li>
                    <li><a href="../auth/adminRegistration.php"><br>Admin Registration</a></li>
                    <!-- <li><a href="managePayments.php">Manage Payments</a></li>
                    <li><a href="manageEmployees.php">Manage Employees</a></li> -->
                </ul>
            </div>
        </div>

    <div class="col-md-10">
        <div class="content">
            <h2>Admin Dashboard</h2>
            <?php if (isset($_SESSION) && array_key_exists('username', $_SESSION)):?>
                <p>Welcome, <?php echo $_SESSION['username'];?>!</p>
            <?php else:?>
                <p>Welcome, Admin!</p>
            <?php endif;?>
            <p>What would you like to do?</p>

            <!-- Dashboard Stats -->

            <div class="row">
                <div class="col-md-4">
                    <div>
                        <h2>Revenue Reports</h2>
                    </div>
                    <div><button onclick="window.location.href='../reports/annualRoomRevenueReport.php'">Annual Room Revenue</button></div>
                    <div><button onclick="window.location.href='../reports/annualBanquetRevenueReport.php'">Annual Banquet Revenue</button></div>
                    <div><button onclick="window.location.href='../reports/monthlyRoomRevenueReport.php'">Monthly Room Revenue</button></div>
                    <div><button onclick="window.location.href='../reports/monthlyBanquetRevenueReport.php'">Monthly Banquet Revenue</button></div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h2>Room Type Bookings</h2>
                        <canvas id="roomTypeChart"></canvas>
                    </div>

                    <script>
                        fetch('../reports/getRoomTypeBookings.php')
                            .then(response => response.json())
                            .then(data => {
                                const labels = data.map(item => item.type_name);
                                const bookings = data.map(item => item.bookings);

                                const ctx = document.getElementById('roomTypeChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: bookings,
                                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                                        }]
                                    }
                                });
                            });
                    </script>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h2>Monthly Room Reservations</h2>
                        <canvas id="monthlyRoomReservationsChart"></canvas>
                    </div>
                    <script>
                        // Fetch Monthly Room Reservations
                        fetch('../reports/getMonthlyRoomReservations.php')
                            .then(response => response.json())
                            .then(data => {
                                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                const roomReservations = Array(12).fill(0);

                                data.forEach(item => {
                                    roomReservations[item.month - 1] = item.reservation_count;
                                });

                                const ctx = document.getElementById('monthlyRoomReservationsChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: months,
                                        datasets: [
                                            {
                                                label: 'Room Reservations',
                                                data: roomReservations,
                                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                                            }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                    </script>
                </div>
            </div>
        </div>
    </div>
    </div>

        <!-- <ul>
            <li><a href="manageCustomers.php" class="btn">Manage Customers</a></li>
            <li><a href="manageReservations.php" class="btn">Manage Reservations</a></li>
            <li><a href="manageRooms.php" class="btn">Manage Rooms</a></li>
            <li><a href="manageBanquetHall.php" class="btn">Manage Banquet Hall</a></li>
            <li><a href="managePayments.php" class="btn">Manage Payments</a></li>
            <li><a href="manageEmployees.php" class="btn">Manage Employees</a></li>
        </ul> -->
</div>
</body>
<!-- <div class="container mt-5">
    

</div> -->
<?php include '../../templates/footer.php'; ?>