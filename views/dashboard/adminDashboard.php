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
                    <li><a href="managePayments.php">Manage Payments</a></li>
                    <li><a href="manageEmployees.php">Manage Employees</a></li>
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
                    <h3>Reservation Reports</h3>
                    <ul>
                        <li><strong>All Reservations:</strong></li>
                        <ul>
                            <?php
                            $reservations = $reservationController->getAllReservations();
                            foreach ($reservations as $reservation) {
                                echo "<li>" . $reservation['reservation_id'] . " - " . $reservation['check_in_date'] . " to " . $reservation['check_out_date'] . " (" . $reservation['reservation_status'] . ")</li>";
                            }
                            ?>
                        </ul>
                        <li><strong>Reservations by Status:</strong></li>
                        <ul>
                            <li>Pending:</li>
                            <ul>
                                <?php
                                $pendingReservations = $reservationController->getReservationsByStatus('pending');
                                foreach ($pendingReservations as $reservation) {
                                    echo "<li>" . $reservation['reservation_id'] . " - " . $reservation['check_in_date'] . " to " . $reservation['check_out_date'] . "</li>";
                                }
                                ?>
                            </ul>
                            <li>Confirmed:</li>
                            <ul>
                                <?php
                                $confirmedReservations = $reservationController->getReservationsByStatus('confirmed');
                                foreach ($confirmedReservations as $reservation) {
                                    echo "<li>" . $reservation['reservation_id'] . " - " . $reservation['check_in_date'] . " to " . $reservation['check_out_date'] . "</li>";
                                }
                                ?>
                            </ul>
                            <li>Cancelled:</li>
                            <ul>
                                <?php
                                $cancelledReservations = $reservationController->getReservationsByStatus('cancelled');
                                foreach ($cancelledReservations as $reservation) {
                                    echo "<li>" . $reservation['reservation_id'] . " - " . $reservation['check_in_date'] . " to " . $reservation['check_out_date'] . "</li>";
                                }
                                ?>
                            </ul>
                        </ul>
                        <li><strong>Reservations by Guest:</strong></li>
                        <ul>
                            <?php
                            $guests = $guestController->index();
                            foreach ($guests as $guest) {
                                $reservations = $reservationController->getReservationsByGuestId($guest['id']);
                                if (count($reservations) > 0) {
                                    echo "<li>" . $guest['first_name'] . " " . $guest['last_name'] . ": </li>";
                                    echo "<ul>";
                                    foreach ($reservations as $reservation) {
                                        echo "<li>" . $reservation['reservation_id'] . " - " . $reservation['check_in_date'] . " to " . $reservation['check_out_date'] . "</li>";
                                    }
                                    echo "</ul>";
                                }
                            }
                            ?>
                        </ul>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Revenue Reports</h3>
                    <ul>
                        <li><strong>Monthly Revenue:</strong></li>
                        <ul>
                            <?php
                            $currentYear = date('Y');
                            for ($month = 1; $month <= 12; $month++) {
                                $revenue = $paymentController->getRevenueByMonth($month, $currentYear);
                                if ($revenue != null) {
                                    echo "<li>Month " . $month . ": LKR " . $revenue . "</li>";
                                }
                            }
                            ?>
                        </ul>
                        <li><strong>Yearly Revenue:</strong></li>
                        <ul>
                            <?php
                            $currentYear = date('Y');
                            $revenue = $paymentController->getRevenueByYear($currentYear);
                            echo "<li>Year " . $currentYear . ": LKR " . $revenue . "</li>";
                            ?>
                        </ul>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Most Booked Room Type</h3>
                    <p><strong>Most Booked Room Type:</strong> <?php
                    $mostBookedRoomTypeId = $roomTypeController->getMostBookedRoomType();
                    $roomType = $roomTypeController->show($mostBookedRoomTypeId);
                    echo $roomType['type_name'];
                    ?>
                    <br><br>
                    <a href="<?php echo BASE_URL; ?>/views/reservation/bookingsByRoomType.php" class="btn">Bookings by Room Type</a>
                    
                    </p>
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

<!-- <div class="container mt-5">
    

</div> -->
<?php include '../../templates/footer.php'; ?>