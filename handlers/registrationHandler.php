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
    $role = $_POST['role'];

    if ($authController->register($username, $password, $role)) {
        echo "Registration successful. <a href='../views/auth/login.php'>Login here</a>.";
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>
