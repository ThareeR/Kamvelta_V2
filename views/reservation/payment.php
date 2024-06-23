<?php
session_start();
include '../../templates/header.php';

$total_amount = $_SESSION['total_amount'];
?>

<div class="container mt-5">
    <h2>Select Payment Method</h2>
    <form action="../../handlers/reservationConfirm.php" method="post">
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
