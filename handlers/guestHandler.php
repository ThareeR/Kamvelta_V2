<?php
session_start();
include '../config/database.php';
include '../controllers/GuestController.php';
    $database = new Database();
    $db = $database->getConnection();
    $guestController = new GuestController($db);

    if (isset($_POST['id']) && isset($_POST['nic']) && isset($_POST['first_name']) 
    && isset($_POST['last_name']) && isset($_POST['contact_number']) && isset($_POST['email']) 
    && isset($_POST['home_address'])) {
    $guestId = $_POST['id'];
    $guestData = [
        'nic' => $_POST['nic'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'contact_number' => $_POST['contact_number'],
        'email' => $_POST['email'],
        'home_address' => $_POST['home_address']
    ];
        if ($guestController->update($guestId, $guestData)) {
            header("Location: ../views/dashboard/manageCustomers.php");
        } else {
            echo "Error updating customer.";
        }
    } elseif (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
        $guestId = $_GET['id'];
        if ($guestController->delete($guestId)) {
            header("Location: ../views/dashboard/manageCustomers.php");
        } else {
            echo "Error deleting customer.";
        }
    } elseif (isset($_POST['nic']) && isset($_POST['first_name']) && isset($_POST['last_name']) && 
        isset($_POST['contact_number']) && isset($_POST['email']) && isset($_POST['home_address'])) {
        $guestData = [
            'nic' => $_POST['nic'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'contact_number' => $_POST['contact_number'],
            'email' => $_POST['email'],
            'home_address' => $_POST['home_address']
        ];
        if ($guestController->create($guestData)) {
            header("Location: ../views/dashboard/manageCustomers.php");
        } else {
            echo "Error creating customer.";
        }
}
?>