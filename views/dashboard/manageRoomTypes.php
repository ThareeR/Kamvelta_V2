<?php 
session_start(); 
include '../../config/database.php';
include '../../templates/header.php'; 
include '../../controllers/RoomTypeController.php'; 

$database = new Database(); 
$db = $database->getConnection(); 
$roomTypeController = new RoomTypeController($db); 
$roomTypes = $roomTypeController->getAll(); 
?>

<div class="container mt-5"> 
    <h2>Manage Room Types</h2> 
    <a href="addRoomType.php" class="btn btn-primary">Add Room Type</a> 

    <table class="table"> 
        <thead> 
            <tr>  
                <th>Room Type ID</th>
                <th>Room Type Name</th> 
                <th>Capacity</th> 
                <th>Unit Price</th> 
                <th>Total Rooms</th> 
                <th>Available Rooms</th> 
                <th>Actions</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($roomTypes as $roomType): ?> 
            <tr> 
                <td><?php echo $roomType['room_type_id']; ?></td> 
                <td><?php echo $roomType['type_name']; ?></td> 
                <td><?php echo $roomType['capacity']; ?></td> 
                <td><?php echo $roomType['unit_price']; ?></td> 
                <td><?php echo $roomType['total_rooms']; ?></td> 
                <td><?php echo $roomType['available_rooms']; ?></td> 
                <td> 
                    <a href="editRoomType.php?id=<?php echo $roomType['room_type_id']; ?>" class="btn btn-sm btn-primary">Edit</a> 
                    <a href="../../handlers/roomTypeHandler.php?id=<?php echo $roomType['room_type_id']; ?>&action=delete" class="btn btn-sm btn-danger">Delete</a> 
                </td> 
            </tr> 
            <?php endforeach; ?> 
        </tbody> 
    </table> 
    
</div> 

<?php include '../../templates/footer.php'; ?>