<?php
session_start();
include '../../templates/header.php';
include '../../controllers/RoomTypeController.php';
?>

<div class="container mt-5">
<h2>Add Room</h2>
    <form action="../../handlers/roomTypeHandler.php" method="post">
        <div class="form-group">
            <label for="type_name">Room Type:</label>
            <input type="text" name="type_name" id="type_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" id="capacity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="unit_price">Unit Price:</label>
            <input type="number" name="unit_price" id="unit_price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="total_rooms">Total Rooms:</label>
            <input type="number" name="total_rooms" id="total_rooms" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Room Type</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>

<?php 
// session_start(); 
// include '../../templates/header.php'; 
// include '../../controllers/RoomTypeController.php';

// $database = new Database(); 
// $db = $database->getConnection(); 
// $roomTypeController = new RoomTypeController($db); 
// $roomTypes = $roomTypeController->getAll();
?> 

<!-- <div class="container mt-5"> 
    <h2>Add Room</h2> 
    <form action="../../handlers/roomHandler.php" method="post"> 
        <div class="form-group"> 
            <label for="room_type_id">Room Type:</label> 
            <select name="room_type_id" id="room_type_id" class="form-control" required>
                <?php //foreach ($roomTypes as $roomType): ?>
                    <option value="<?php //echo $roomType['id']; ?>"><?php //echo $roomType['type_name']; ?></option>
                <?php //endforeach; ?>
            </select>
        </div>
        <div class="form-group"> 
            <label for="room_number">Room Number:</label> 
            <input type="text" name="room_number" id="room_number" class="form-control" required> 
        </div>
        <div class="form-group"> 
            <label for="status">Status:</label> 
            <input type="text" name="status" id="status" class="form-control" required> 
        </div> 
        <button type="submit" class="btn btn-primary">Add Room</button> 
    </form> 
</div>  -->

<?php //include '../../templates/footer.php'; ?>

<!-- ---- -->

<?php 
// session_start(); 
// include '../../config/database.php';
// include '../../templates/header.php'; 
// include '../../controllers/RoomTypeController.php'; 

// $database = new Database(); 
// $db = $database->getConnection(); 
// $roomTypeController = new RoomTypeController($db); 

// if ($_POST) {
//     $roomTypeController->createRoomType($_POST);
//     header('Location: manageRoomTypes.php');
//     exit;
// }
?>

<!-- <div class="container mt-5"> 
    <h2>Add Room Type</h2> 
    <form action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="room_type_name">Room Type Name</label>
            <inputtype="text" class="form-control" id="room_type_name" name="room_type_name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Room Type</button>
    </form>
</div>  -->

<?php //include '../../templates/footer.php';?>
