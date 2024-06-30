<?php
session_start();
include '../../templates/header.php';
include '../../controllers/ReservationController.php';
include '../../controllers/GuestController.php';
include '../../controllers/ReservationItemController.php';
$database = new Database();
$db = $database->getConnection();
$reservationController = new ReservationController($db);
$guestController = new GuestController($db);
$reservationItemController = new ReservationItemController($db);
$reservationId = isset($_GET['id']) ? $_GET['id'] : null;
if ($reservationId) {
  $reservation = $reservationController->show($reservationId);
  $guest = $guestController->show($reservation['guest_id']);
  $reservationItems = $reservationItemController->getReservationItemsByReservationId($reservationId);
}
?>
<div class="container mt-5">
<h2>Reservation Details</h2>
<p><strong>Reservation ID:</strong> <?php echo $reservation['reservation_id']; 
?></p>
<p><strong>Guest Name:</strong> <?php echo $guest['first_name'] . ' ' . 
$guest['last_name']; ?></p>
<p><strong>Check-in Date:</strong> <?php echo $reservation['check_in_date']; 
?></p>
<p><strong>Check-out Date:</strong> <?php echo $reservation['check_out_date']; 
?></p>
<p><strong>Status:</strong> <?php echo $reservation['reservation_status']; 
?></p>
<h3>Reservation Items</h3>
<table class="table">
<thead>
<tr>
<th>Room Type</th>
<th>Room Count</th>
<th>Rate Per Unit</th>
<th>Total Charge</th>
</tr>
</thead>
<tbody>
<?php foreach ($reservationItems as $item): ?>
<tr>
<td><?php echo $item['type_name']; ?></td>
<td><?php echo $item['room_count']; ?></td>
<td><?php echo $item['rate_per_unit']; ?></td>
<td><?php echo $item['total_charge']; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php include '../../templates/footer.php'; ?>