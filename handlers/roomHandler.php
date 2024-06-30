<?php
session_start();
include_once '../config/Database.php';
include_once '../controllers/RoomController.php';
include_once '../models/Room.php';

$database = new Database();
$db = $database->getConnection();
$roomController = new RoomController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data= [$room_type_id = $_POST['room_type_id'],
    $room_number = $_POST['room_number'],
    $status = $_POST['status']];
    if ($roomController->createRoom($data)) {
        $_SESSION['message'] = "Room added successfully";
    } else {
        $_SESSION['message'] = "Failed to add room";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($roomController->deleteRoom($id)) {
        $_SESSION['message'] = "Room deleted successfully";
    } else {
        $_SESSION['message'] = "Failed to delete room";
    }
}

header("Location: ../views/dashboard/manageRooms.php");
?>
