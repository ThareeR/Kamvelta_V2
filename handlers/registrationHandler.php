<?php
session_start();
include '../config/database.php';
include '../controllers/AuthController.php';

$database = new Database();
$db = $database->getConnection();
$authController = new AuthController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];   // newly added
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Checking if the username or email already exists
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email); // newly added
    $stmt->execute();

    if($stmt->rowCount() >0){
        header("Location: ../views/auth/register.php?error=username_exists");
        exit;
    }
    else{
        if ($authController->register($username, $email, $password, $role)) {
            if($role=='admin'){
                header("Location: ../views/dashboard/adminDashboard.php");
            }
            else{
            // echo "Registration successful. <a href='../views/auth/login.php'>Login here</a>.";
            header("Location: ../views/auth/registerSuccess.php");
            }
        } else {
            echo "Registration failed. Please try again.";
        }
    }  
}
?>

