<?php
//session_start();
include_once '../../templates/header.php';
include_once '../../config/database.php';
// include_once '../../controllers/RoomController.php';

// $database = new Database();
// $db = $database->getConnection();

// $controller = new RoomController($db);

// if($_POST) {
//     $data = [
//         'room_type_id' => $_POST['room_type_id'],
//         'status' => $_POST['status']
//     ];
//     if($controller->createRoom($data)) {
//         echo "Room was created.";
//     } else {
//         echo "Unable to create room.";
//     }
// }

?>
<div class="container mt-5">
    <h2>Add Room</h2>
    <form action="../../handlers/roomHandler.php" method="post">
        <label for="room_type_id">Room Type ID</label>
        <!-- <input type="text" id="room_type_id" name="room_type_id"><br> -->
        <select name="room_type_id" id="room_type_id" class="form-control" required>
            <option value="1">1 - Single</option>
            <option value="2">2 - Double</option>
            <option value="3">3 - Triple</option>
        </select>

        <label for="status">Status</label>
        <!-- <input type="text" id="status" name="status"><br> -->
        <select name="status" id="status" class="form-control" required>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="booked">Booked</option>
        </select>

        <button type="submit" class="btn btn-primary">Add Room</button>

    </form>
</div>



<?php 
// session_start(); 
// include '../../templates/header.php'; 
// include '../../config/Database.php'; 
// include '../../controllers/RoomController.php';
// include '../../controllers/RoomTypeController.php';

// $database = new Database(); 
// $db = $database->getConnection(); 
// $roomTypeController = new RoomTypeController($db); 
// $roomController = new RoomController($db);
// $roomTypes = $roomTypeController->getAll();
?> 

<!-- <div class="container mt-5"> 
    <h2>Add Room</h2> 
    <?php
    // if(isset($_SESSION['message'])) {
    //     echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    //     unset($_SESSION['message']);
    // }
    ?>
    <form action="../../handlers/roomHandler.php" method="post"> 
        <div class="form-group"> 
            <label for="room_number">Room Number:</label> 
            <input type="text" name="room_number" id="room_number" class="form-control" required> 
        </div>
        <div class="form-group"> 
            <label for="room_type_id">Room Type:</label> 
            <select name="room_type_id" id="room_type_id" class="form-control" required>
                <?php // foreach ($roomTypes as $roomType): ?>
                    <option value="<?php //echo $roomType['id']; ?>"><?php // echo $roomType['type_name']; ?></option>
                <?php // endforeach; ?>
            </select>
        </div>
        <div class="form-group"> 
            <label for="status">Status:</label> 
            <input type="text" name="status" id="status" class="form-control" required> 
        </div> 
        <button type="submit" class="btn btn-primary">Add Room</button> 
    </form> 
</div>  -->

<?php  include '../../templates/footer.php'; ?>
