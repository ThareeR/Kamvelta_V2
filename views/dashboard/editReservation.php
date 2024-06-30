<?php
session_start();
include '../../templates/header.php';
include '../../controllers/ReservationController.php';
include '../../controllers/GuestController.php';
include '../../controllers/RoomTypeController.php';
$database = new Database();
$db = $database->getConnection();
$reservationController = new ReservationController($db);
$guestController = new GuestController($db);
$roomTypeController = new RoomTypeController($db);
$reservationId = isset($_GET['id']) ? $_GET['id'] : null;
if ($reservationId) {
  $reservation = $reservationController->show($reservationId);
  $guest = $guestController->show($reservation['guest_id']);
  $roomTypes = $roomTypeController->getAll();
}
?>
<div class="container mt-5">
<h2>Edit Reservation</h2>
<form action="../../handlers/reservationHandler.php" method="post">
<input type="hidden" name="id" value="<?php echo $reservationId; ?>">
<div class="form-group">
<label for="guest_id">Guest:</label>
<select name="guest_id" id="guest_id" class="form-control">
<option value="<?php echo $guest['id']; ?>" selected><?php echo 
$guest['first_name'] . ' ' . $guest['last_name']; ?></option>
</select>
</div>
<div class="form-group">
<label for="check_in_date">Check-in Date:</label>
<input type="date" name="check_in_date" id="check_in_date" class="form-control" 
value="<?php echo $reservation['check_in_date']; ?>">
</div>
<div class="form-group">
<label for="check_out_date">Check-out Date:</label>
<input type="date" name="check_out_date" id="check_out_date" class="form-control" 
value="<?php echo $reservation['check_out_date']; ?>">
</div>
<div class="form-group">
<label for="reservation_status">Status:</label>
<select name="reservation_status" id="reservation_status" class="form-control">
<option value="pending" <?php if ($reservation['reservation_status'] == 
'pending') echo 'selected'; ?>>Pending</option>
<option value="confirmed" <?php if ($reservation['reservation_status'] == 
'confirmed') echo 'selected'; ?>>Confirmed</option>
<option value="cancelled" <?php if ($reservation['reservation_status'] == 
'cancelled') echo 'selected'; ?>>Cancelled</option>
</select>
</div>
<button type="submit" class="btn btn-primary">Update Reservation</button>
</form>
</div>
<?php include '../../templates/footer.php'; ?>