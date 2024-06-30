<?php
include_once '../../config/database.php';
include_once '../../controllers/RoomController.php';

$database = new Database();
$db = $database->getConnection();

$controller = new RoomController($db);

if($_POST) {
    $id = $_POST['room_id'];
    $data = [
        'room_type_id' => $_POST['room_type_id'],
        'status' => $_POST['status']
    ];
    if($controller->updateRoom($id, $data)) {
        echo "Room was updated.";
    } else {
        echo "Unable to update room.";
    }
}
?>

<div class="container mt-5">
    <h2>Edit Room</h2>
    <form action="editRoom.php" method="post">
        <!-- <label for="room_id">Room ID</label>
        <input type="text" id="room_id" name="room_id"><br> -->
        <br>
        <label for="room_type_id">Room Type ID</label>
        <!-- <input type="text" id="room_type_id" name="room_type_id"><br> -->
        <select name="room_type_id" id="room_type_id" class="form-control" required>
            <option value="1">1 - Single</option>
            <option value="2">2 - Double</option>
            <option value="3">3 - Triple</option>
        </select>
        <br><br>
        <label for="status">Status</label>
        <!-- <input type="text" id="status" name="status"><br> -->
        <select name="status" id="status" class="form-control" required>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="booked">Booked</option>
        </select>
        <br><br>
        <!-- <input type="submit" value="Update Room"> -->
        <button type="submit" class="btn btn-primary">Update Room Type</button>
    </form>
</div>
