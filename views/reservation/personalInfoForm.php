<?php 
session_start();
include '../../templates/header.php'; 

$hall_id = $_SESSION['hall_id'];
$event_date = $_SESSION['event_date'];
$start_time = $_SESSION['start_time'];
$end_time = $_SESSION['end_time'];
$number_of_guests = $_SESSION['number_of_guests'];

?>
<div class="container mt-5">
    <h2>Guest Information</h2>
    <form action="../../handlers/personalInfoHandler.php" method="POST">
        <input type="hidden" name="hall_id" value="<?php echo $_SESSION['hall_id']; ?>">
        <input type="hidden" name="event_date" value="<?php echo $_SESSION['event_date']; ?>">
        <input type="hidden" name="start_time" value="<?php echo $_SESSION['start_time']; ?>">
        <input type="hidden" name="end_time" value="<?php echo $_SESSION['end_time']; ?>">
        <input type="hidden" name="number_of_guests" value="<?php echo $_SESSION['number_of_guests']; ?>">
        <div class="form-group">
            <label for="nic">NIC:</label>
            <input type="text" name="nic" id="nic" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address:</label>
            <textarea name="home_address" id="home_address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>
