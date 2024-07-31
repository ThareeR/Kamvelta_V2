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
            <span id="nic-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
            <span id="first-name-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
            <span id="last-name-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
            <span id="contact-number-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
            <span id="email-error" style="color: red; font-size: 12px;"></span>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address:</label>
            <textarea name="home_address" id="home_address" class="form-control" required></textarea>
            <span id="home-address-error" style="color: red; font-size: 12px;"></span>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
</div>

<!-- Form Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nic').on('input', function() {
            var nic = $(this).val();
            if (nic.length < 10 || nic.length > 12) {
                $('#nic-error').text('Invalid NIC number. It should be between 10 to 12 characters.');
            } else {
                $('#nic-error').text('');
            }
        });

        $('#first_name').on('input', function() {
            var firstName = $(this).val();
            if (!firstName.match(/^[a-zA-Z ]+$/)) {
                $('#first-name-error').text('Invalid first name. It should only contain letters and spaces.');
            } else {
                $('#first-name-error').text('');
            }
        });

        $('#last_name').on('input', function() {
            var lastName = $(this).val();
            if (!lastName.match(/^[a-zA-Z ]+$/)) {
                $('#last-name-error').text('Invalid last name. It should only contain letters and spaces.');
            } else {
                $('#last-name-error').text('');
            }
        });

        $('#contact_number').on('input', function() {
            var contactNumber = $(this).val();
            if (!contactNumber.match(/^\d{10}$/)) {
                $('#contact-number-error').text('Invalid contact number. It should be a 10-digit number.');
            } else {
                $('#contact-number-error').text('');
            }
        });

        $('#email').on('input', function() {
            var email = $(this).val();
            if (!email.match(/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,}$/)) {
                $('#email-error').text('Invalid email address.');
            } else {
                $('#email-error').text('');
            }
        });

        $('#home_address').on('input', function() {
            var homeAddress = $(this).val();
            if (homeAddress.length < 5) {
                $('#home-address-error').text('Invalid home address. It should be at least 5 characters.');
            } else {
                $('#home-address-error').text('');
            }
        });
    });
</script>
<?php include '../../templates/footer.php'; ?>
