<?php
session_start();
include '../config/database.php';
include '../controllers/RoomTypeController.php';
$database = new Database();
$db = $database->getConnection();
$roomTypeController = new RoomTypeController($db);
if (isset($_POST['id']) && isset($_POST['type_name']) && isset($_POST['capacity']) && 
isset($_POST['unit_price']) && isset($_POST['total_rooms'])) {
  $roomTypeId = $_POST['id'];
  $roomTypeData = [
    'type_name' => $_POST['type_name'],
    'capacity' => $_POST['capacity'],
    'unit_price' => $_POST['unit_price'],
    'total_rooms' => $_POST['total_rooms']
  ];
  if ($roomTypeController->update($roomTypeId, $roomTypeData)) {
    header("Location: ../views/dashboard/manageRooms.php");
  } else {
    echo "Error updating room.";
  }
} elseif (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 
'delete') {
  $roomTypeId = $_GET['id'];
  if ($roomTypeController->delete($roomTypeId)) {
    header("Location: ../views/dashboard/manageRooms.php");
  } else {
    echo "Error deleting room.";
  }
} elseif (isset($_POST['type_name']) && isset($_POST['capacity']) && 
isset($_POST['unit_price']) && isset($_POST['total_rooms'])) {
  $roomTypeData = [
    'type_name' => $_POST['type_name'],
    'capacity' => $_POST['capacity'],
    'unit_price' => $_POST['unit_price'],
    'total_rooms' => $_POST['total_rooms']
  ];
  if ($roomTypeController->create($roomTypeData)) {
    header("Location: ../views/dashboard/manageRooms.php");
  } else {
    echo "Error creating room.";
  }
}
?>