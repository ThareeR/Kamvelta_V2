<?php
include '../../templates/header.php';
include '../../config/database.php';
include '../../controllers/BanquetHallController.php';
include '../../controllers/GuestController.php';

$database = new Database();
$db = $database->getConnection();

$banquetHallController = new BanquetHallController($db);
$guestController = new GuestController($db);

$hall_id = $_GET['hall_id'];
$guest_id = $_GET['guest_id'];
$event_date = $_GET['event_date'];
$total_charge = $_GET['total_charge'];

$hall = $banquetHallController->getOne($hall_id);
$guest = $guestController->getByNIC($guest_id);

?>
<div class="container mt-5">
    <h2>Reservation Confirmation</h2>
    <p>Thank you for your reservation.</p>
    <p><strong>Hall Name:</strong> <?php echo $hall->hall_name; ?></p>
    <!-- <p><strong>Guest Name:</strong> <?php echo $guest?->firstName; ?></p> -->
    <p><strong>Guest ID:</strong> <?php echo $guest_id; ?></p>
    <p><strong>Event Date:</strong> <?php echo $event_date; ?></p>
    <p><strong>Total Charge:</strong> <?php echo $total_charge; ?></p>
</div>
<?php include '../../templates/footer.php'; ?>
