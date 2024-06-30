

<?php 
session_start(); 
include '../../config/database.php';
include '../../templates/header.php'; 
include '../../controllers/RoomController.php'; 
include '../../controllers/RoomTypeController.php';

$database = new Database(); 
$db = $database->getConnection(); 
$roomController = new RoomController($db); 
$roomTypeController = new RoomTypeController($db);
$rooms = $roomController->readAllRooms(); 
?> 

<div class="container mt-5"> 
    <h2>Manage Rooms</h2> 

    <div class="float-right">
        <a href="manageRoomTypes.php" class="btn btn-secondary">Room Types</a>
    </div>

    <a href="addRoom.php" class="btn btn-primary">Add Room</a> 

    <table class="table"> 
        <thead> 
            <tr>  
                <th>Room Number</th>
                <th>Room Type ID</th> 
                <th>Status</th> 
                <th>Actions</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($rooms as $room): ?> 
            <tr> 
                <td><?php echo $room['room_id']; ?></td> 
                <td><?php echo $room['room_type_id']; ?></td> 
                <td><?php echo $room['status']; ?></td> 
                <td> 
                    <a href="editRoom.php?id=<?php echo $room['room_id']; ?>" class="btn btn-sm btn-primary">Edit</a> 
                    <a href="../../handlers/roomHandler.php?id=<?php echo $room['room_id']; ?>&action=delete" class="btn btn-sm btn-danger">Delete</a> 
                </td> 
            </tr> 
            <?php endforeach; ?> 
        </tbody> 
    </table> 
    
</div> 

<?php include '../../templates/footer.php'; ?>
