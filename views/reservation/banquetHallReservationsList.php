<?php 
include '../../templates/header.php'; 
include '../../config/database.php';
include '../../controllers/BanquetHallController.php'; 

$database = new Database(); 
$db = $database->getConnection(); 
$controller = new BanquetHallController($db); 
$halls = $controller->getAll();
?>
<div class="container mt-5">
    <h2>Available Banquet Halls</h2>
    <div class="row">
        <?php foreach ($halls as $hall): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="../../assets/images/<?php echo strtolower(str_replace(' ', '_', $hall['hall_name'])) . '_' . $hall['hall_id'] . '.jpg'; ?>" class="card-img-top img-fluid" alt="Hall Image">
                <!-- <img src="../../assets/images/bambooHall.jpg" class="card-img-top" alt="Hall Image"> -->
                <div class="card-body">
                    <h5 class="card-title"><?php echo $hall['hall_name']; ?></h5>
                    <p class="card-text">Capacity: <?php echo $hall['capacity']; ?></p>
                    <p class="card-text">Charge per Hour: <?php echo $hall['charge_per_hour']; ?></p>
                    <!-- <a href="banquetHallReservationForm.php?hall_id=<?php //echo $hall['hall_id']; ?>" class="btn btn-primary">Reserve</a> -->
                    <a href="banquetHallDate.php?hall_id=<?php echo $hall['hall_id']; ?>" class="btn btn-primary">Reserve</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include '../../templates/footer.php'; ?>




<!-- 1 -->
<?php 
// include '../../templates/header.php'; 
// include '../../controllers/BanquetHallReservationController.php'; 
// include '../../config/database.php';

// $database = new Database(); 
// $db = $database->getConnection(); 
// $controller = new BanquetHallReservationController($db); 
// $reservations = $controller->getAll();
?>
<!-- <div class="container mt-5">
    <h2>Banquet Hall Reservations</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Guest ID</th>
                <th>Hall ID</th>
                <th>Event Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Number of Guests</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php //foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php //echo $reservation['reservation_id']; ?></td>
                    <td><?php //echo $reservation['guest_id']; ?></td>
                    <td><?php //echo $reservation['hall_id']; ?></td>
                    <td><?php //echo $reservation['event_date']; ?></td>
                    <td><?php //echo $reservation['start_time']; ?></td>
                    <td><?php //echo $reservation['end_time']; ?></td>
                    <td><?php //echo $reservation['number_of_guests']; ?></td>
                    <td><?php //echo $reservation['status']; ?></td>
                </tr>
            <?php //endforeach; ?>
        </tbody>
    </table>
</div> -->
<?php //include '../../templates/footer.php'; ?>
