<?php
session_start();
include '../../templates/header.php';

$availableRooms = $_SESSION['available_rooms'];
?>

<div class="container mt-5">
    <h2>Select Rooms</h2>
    <form action="../../handlers/reservationHandler.php" method="post">
        <input type="hidden" name="check_in_date" value="<?php echo $_SESSION['check_in_date']; ?>">
        <input type="hidden" name="check_out_date" value="<?php echo $_SESSION['check_out_date']; ?>">
        
        <?php foreach ($availableRooms as $room) { ?>
        <div class="form-group">
            <label for="room_type_<?php echo $room['room_type_id']; ?>"><?php echo $room['type_name']; ?> Rooms (Available: <?php echo $room['available_rooms']; ?>):</label>
            <input type="number" name="room_count[]" id="room_type_<?php echo $room['room_type_id']; ?>" class="form-control" min="0" max="<?php echo $room['available_rooms']; ?>">
            <input type="hidden" name="room_type_id[]" value="<?php echo $room['room_type_id']; ?>">
            <input type="hidden" name="rate_per_unit[]" value="<?php echo $room['unit_price']; ?>">
        </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Book</button>
    </form>
</div>

<?php
include '../../templates/footer.php';
?>

<?php
// session_start();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../auth/login.php');
//     exit;
// }

// include '../../config/database.php';
// include '../../controllers/ReservationController.php';

// $database = new Database();
// $db = $database->getConnection();
// $reservationController = new ReservationController($db);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $check_in = $_POST['check_in'];
//     $check_out = $_POST['check_out'];
//     $room_selections = $_POST['room_selections'];

//     $_SESSION['check_in'] = $check_in;
//     $_SESSION['check_out'] = $check_out;
//     $_SESSION['room_selections'] = $room_selections;

//     header('Location: personalInfo.php');
//     exit;
// }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php //include '../../templates/header.php'; ?>

    <title>Select Rooms</title>
</head>
<body>
    <form method="POST" action=""> 
         <label for="check_in">Check-in Date:</label>
        <input type="date" id="check_in" name="check_in" required>
        
        <label for="check_out">Check-out Date:</label>
        <input type="date" id="check_out" name="check_out" required> 
        
        <div id="room_selections"> 
            
            <div>
                <label for="single_room_count">Single Rooms:</label>
                <input type="number" id="single_room_count" name="room_selections[single]" min="0" value="0">
            </div>
            <div>
                <label for="double_room_count">Double Rooms:</label>
                <input type="number" id="double_room_count" name="room_selections[double]" min="0" value="0">
            </div>
            <div>
                <label for="triple_room_count">Triple Rooms:</label>
                <input type="number" id="triple_room_count" name="room_selections[triple]" min="0" value="0">
            </div>
        </div>
        
        <button type="submit">Book</button>
    </form>
</body>
</html> -->