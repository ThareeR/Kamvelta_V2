<?php
session_start();
include_once '../../templates/header.php';
include_once '../../config/database.php';
include_once '../../controllers/RoomController.php';

$database = new Database();
$db = $database->getConnection();
$roomController = new RoomController($db);
$roomId = isset($_GET['room_id']) ? $_GET['room_id'] : null;

if ($roomId) {
    $room = $roomController->show($roomId);
}

?>

<div class="container mt-5">
    <h2>Edit Room</h2>
    <form action="../../handlers/roomHandler.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
        <div class="form-group">
            <label for="room_type_id">Room Type ID:</label>
            <select name="room_type_id" id="room_type_id" class="form-control" required>
                <option value="1" <?php echo ($room['room_type_id'] == 1) ? 'selected' : ''; ?>>1 - Single</option>
                <option value="2" <?php echo ($room['room_type_id'] == 2) ? 'selected' : ''; ?>>2 - Double</option>
                <option value="3" <?php echo ($room['room_type_id'] == 3) ? 'selected' : ''; ?>>3 - Triple</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available" <?php echo ($room['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                <option value="unavailable" <?php echo ($room['status'] == 'unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                <option value="booked" <?php echo ($room['status'] == 'booked') ? 'selected' : ''; ?>>Booked</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
</div>

<?php include '../../templates/footer.php'; ?>

<?php
// include_once '../../config/database.php';
// include_once '../../controllers/RoomController.php';

// $database = new Database();
// $db = $database->getConnection();

// $controller = new RoomController($db);

// if($_POST) {
//     $roomId = $_POST['room_id'];
//     $data = [
//         'room_type_id' => $_POST['room_type_id'],
//         'status' => $_POST['status']
//     ];
//     if($controller->updateRoom($roomId, $data)) {
//         echo "Room was updated.";
//     } else {
//         echo "Unable to update room.";
//     }
// }
?>

<!-- <div class="container mt-5">
    <h2>Edit Room</h2>
    <form action="editRoom.php" method="post"> -->
        <!-- <label for="room_id">Room ID</label>
        <input type="text" id="room_id" name="room_id"><br> -->
        <!-- <input type="hidden" name="room_id" value="<?php //echo $roomId; ?>">
        <br>
        <label for="room_type_id">Room Type ID</label> -->
        <!-- <input type="text" id="room_type_id" name="room_type_id"><br> -->
        <!-- <select name="room_type_id" id="room_type_id" class="form-control" required>
            <option value="1">1 - Single</option>
            <option value="2">2 - Double</option>
            <option value="3">3 - Triple</option>
        </select>
        <br><br>
        <label for="status">Status</label> -->
        <!-- <input type="text" id="status" name="status"><br> -->
        <!-- <select name="status" id="status" class="form-control" required>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="booked">Booked</option>
        </select>
        <br><br> -->
        <!-- <input type="submit" value="Update Room"> -->
        <!-- <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
</div> -->
