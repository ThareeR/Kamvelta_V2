<?php
session_start();
include '../../templates/header.php';
include '../../config/database.php';
include '../../controllers/RoomTypeController.php';

$database = new Database();
$db = $database->getConnection();
$roomTypeController = new RoomTypeController($db);
$roomTypeId = isset($_GET['id']) ? $_GET['id'] : null;

if ($roomTypeId) {
  $roomType = $roomTypeController->show($roomTypeId);
}
?>
<div class="container mt-5">
  <h2>Edit Room</h2>
  <form action="../../handlers/roomTypeHandler.php" method="post">
    <input type="hidden" name="id" value="<?php echo $roomTypeId; ?>">
    <div class="form-group">
      <label for="type_name">Room Type:</label>
      <input type="text" name="type_name" id="type_name" class="form-control" required value="<?php echo $roomType['type_name']; ?>">
    </div>
    <div class="form-group">
      <label for="capacity">Capacity:</label>
      <input type="number" name="capacity" id="capacity" class="form-control" required value="<?php echo $roomType['capacity']; ?>">
    </div>
    <div class="form-group">
      <label for="unit_price">Unit Price:</label>
      <input type="number" name="unit_price" id="unit_price" class="form-control" required value="<?php echo $roomType['unit_price']; ?>">
    </div>
    <div class="form-group">
      <label for="total_rooms">Total Rooms:</label>
      <input type="number" name="total_rooms" id="total_rooms" class="form-control" required value="<?php echo $roomType['total_rooms']; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update Room Type</button>
  </form>
</div>
<?php include '../../templates/footer.php'; ?>

<?php
// session_start();
// include '../../config/database.php';
// include '../../templates/header.php';
// include '../../controllers/RoomTypeController.php';

// $database = new Database();
// $db = $database->getConnection();
// $roomTypeController = new RoomTypeController($db);

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $roomType = $roomTypeController->getById($id);
// }

// if ($_POST) {
//     $roomTypeController->updateRoomType($_POST, $id);
//     header('Location: manageRoomTypes.php');
//     exit;
// }

?>

<!-- <div class="container mt-5">
    <h2>Edit Room Type</h2>
    <form action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="room_type_name">Room Type Name</label>
            <input type="text" class="form-control" id="room_type_name" name="room_type_name" value="<?php //echo $roomType['type_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required><?php //echo $roomType['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Room Type</button>
    </form>
</div> -->

<?php //include '../../templates/footer.php'; ?>

<?php
// deleteRoomType.php
// session_start();
// include '../../config/database.php';
// include '../../controllers/RoomTypeController.php';

// $database = new Database();
// $db = $database->getConnection();
// $roomTypeController = new RoomTypeController($db);

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $roomTypeController->deleteRoomType($id);
//     header('Location: manageRoomTypes.php');
//     exit;
// }

?>