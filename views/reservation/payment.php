<?php
session_start();
include '../../templates/header.php';

// Ensure total_charge is correctly retrieved from the session
if (!isset($_SESSION['total_charge'])) {
    echo "Total charge not set.";
    exit;
}

$total_amount = $_SESSION['total_charge'];
?>

<div class="container mt-5">
    <h2>Select Payment Method</h2>
    <form action="../../handlers/reservationConfirmHandler.php" method="post">
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="1">Online</option>
                <option value="2">Credit/Debit Card</option>
                <option value="3">On-site</option>
            </select>
        </div>
        <div class="form-group">
            <label for="total_amount">Total Amount:</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control" value="<?php echo $total_amount; ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Confirm Reservation</button>
    </form>
</div>

<?php
include '../../templates/footer.php';
?>
