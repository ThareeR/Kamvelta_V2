<?php
session_start();
include '../config/database.php';
include '../controllers/AuthController.php';

$database = new Database();
$db = $database->getConnection();
$authController = new AuthController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($authController->login($username, $password, $_SESSION)) {
        // Login successful, redirection handled within the login method
    } else {
        echo "Invalid username or password.";
    }
}

?>