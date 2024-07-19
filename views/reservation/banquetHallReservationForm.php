<?php 
include '../../templates/header.php'; 
include '../../controllers/BanquetHallController.php'; 
include '../../config/database.php';

$database = new Database(); 
$db = $database->getConnection(); 
$hallController = new BanquetHallController($db); 

// if (isset($_GET['hall_id'])) {
//     $hall_id = $_GET['hall_id'];
//     $halls = $hallController->getOne($hall_id);
// } else {
//     // handle the case where hall_id is not provided
//     echo "Error: hall_id is not provided";
//     exit;
// }

$hall_id = $_GET['hall_id'];
$hall = $hallController->getOne($hall_id);

// Added to check if $hall might be false.
if (!$hall) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Error: Banquet hall details are not found.</div></div>";
    include '../../templates/footer.php';
    exit();
}

?>

<div class="container mt-5">
    <h2>Reserve <?php echo htmlspecialchars($hall->hall_name, ENT_QUOTES, 'UTF-8'); ?></h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form action="../../handlers/banquetHallReservationHandler.php" method="POST">
        <input type="hidden" name="hall_id" value="<?php echo htmlspecialchars($hall->hall_id, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>
        <div class="form-group">
            <label for="number_of_guests">Number of Guests</label>
            <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" required>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>

<!-- <div class="container mt-5">
    <h2>Reserve <?php //echo $hall['hall_name']; ?></h2>

    <?php //if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            // echo $_SESSION['error'];
            // unset($_SESSION['error']);
            ?>
        </div>
    <?php //endif; ?>

    <form action="../../handlers/banquetHallReservationHandler.php" method="POST">
        <input type="hidden" name="hall_id" value="<?php //echo $hall['hall_id']; ?>">
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>
        <div class="form-group">
            <label for="number_of_guests">Number of Guests</label>
            <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" required>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div> -->

<!-- <div class="container mt-5">
    <h2>Make a Banquet Hall Reservation</h2>
    <form action="../../handlers/banquetHallReservationHandler.php" method="POST">
        <div class="form-group">
            <label for="guest_id">Guest ID</label>
            <input type="text" class="form-control" id="guest_id" name="guest_id" required>
        </div>
        <div class="form-group">
            <label for="hall_id">Hall</label>
            <select class="form-control" id="hall_id" name="hall_id" required>
                <?php //foreach ($halls as $hall): ?>
                    <option value="<?php //echo $hall['hall_id']; ?>"><?php //echo $hall['hall_name']; ?></option>
                <?php //endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>
        <div class="form-group">
            <label for="number_of_guests">Number of Guests</label>
            <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" required>
        </div>
        <button type="submit" class="btn btn-primary">Reserve</button>
    </form>
</div> -->
<?php include '../../templates/footer.php'; ?>
