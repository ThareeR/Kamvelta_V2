<?php
include '../config/database.php';
include '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Verify the token
    $query = "SELECT * FROM users WHERE reset_token = :token AND reset_token_expiry > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Update the password
        $new_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo 'Your password has been reset successfully.<a href="../views/auth/login.php">Login here</a>.';
    } else {
        echo 'Invalid or expired token';
    }
}
?>


<?php
// include '../config/database.php';
// include '../models/User.php';

// $database = new Database();
// $db = $database->getConnection();
// $user = new User($db);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $token = $_POST['token'];
//     $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

//     if ($user->verifyResetToken($token)) {
//         $user->id = $user->verifyResetToken($token)['id'];
//         if ($user->updatePassword($new_password)) {
//             // Clear the reset token
//             $query = "UPDATE users SET reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";
//             $stmt = $db->prepare($query);
//             $stmt->bindParam(':id', $user->id);
//             $stmt->execute();

//             echo 'Password has been reset successfully. <a href="../views/auth/login.php">Login here</a>.';
//         } else {
//             echo 'Failed to reset password. Please try again.';
//         }
//     } else {
//         echo 'Invalid or expired reset token. Please request a new password reset.';
//     }
// }
?>
