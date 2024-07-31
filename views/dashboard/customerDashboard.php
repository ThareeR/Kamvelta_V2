<?php 
session_start();
include '../../templates/header.php'; 
?>
<div class="container mt-5">
<h2>Customer Dashboard</h2>

    <?php if (isset($_SESSION) && array_key_exists('username', $_SESSION)):?>
        <p>Welcome, <?php echo $_SESSION['username'];?>!</p>
    <?php else:?>
        <p>Welcome, guest!</p>
    <?php endif;?>

    <p>What would you like to do?</p>
    <button class="btn btn-primary" onclick="location.href='../reservation/checkAvailability.php'">Make a Room Reservation</button>
    <button class="btn btn-primary" onclick="location.href='../reservation/banquetHallReservationsList.php'">Make a Banquet Hall Reservation</button>
    <!-- <ul>
        <li><a href="../reservation/checkAvailability.php" class="btn btn-primary">Make a Room Reservation</a></li>
        <p></p>
        <li><a href="../reservation/banquetHallReservationsList.php" class="btn btn-primary">Make a Banquet Hall Reservation</a></li>
    </ul> -->
    
</div>
<?php include '../../templates/footer.php'; ?>
