<?php
session_start();
include '../../templates/header.php'; 
?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <?php if (isset($_SESSION) && array_key_exists('username', $_SESSION)):?>
        <p>Welcome, <?php echo $_SESSION['username'];?>!</p>
    <?php else:?>
        <p>Welcome, guest!</p>
    <?php endif;?>
    <p>What would you like to do?</p>
    <ul>
        <li><a href="manageCustomers.php" class="btn btn-primary">Manage Customers</a></li>
        <li><a href="manageReservations.php" class="btn btn-primary">Manage Reservations</a></li>
        <li><a href="manageRooms.php" class="btn btn-primary">Manage Rooms</a></li>
        <li><a href="manageBanquetHall.php" class="btn btn-primary">Manage Banquet Hall</a></li>
        <li><a href="managePayments.php" class="btn btn-primary">Manage Payments</a></li>
        <li><a href="manageEmployees.php" class="btn btn-primary">Manage Employees</a></li>
    </ul>
</div>
<?php include '../../templates/footer.php'; ?>