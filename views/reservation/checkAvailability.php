<?php
include '../../templates/header.php';
?>

<div class="container mt-5">
    <h2>Check Room Availability</h2>
    <form action="../../handlers/reservationHandler.php" method="post">
        <div class="form-group">
            <label for="check_in_date">Check-in Date:</label>
            <input type="date" name="check_in_date" id="check_in_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="check_out_date">Check-out Date:</label>
            <input type="date" name="check_out_date" id="check_out_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Check Availability</button>
    </form>
</div>

<?php
include '../../templates/footer.php';
?>
