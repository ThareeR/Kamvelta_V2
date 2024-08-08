<?php
require __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../config/database.php';
include __DIR__.'/../models/User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(16));

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Save the reset token in the database
        $query = "UPDATE users SET reset_token = :token, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Send the email
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_USER'], 'Kamvelta Holiday Resort');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Click the link to reset your password: <a href="http://'. $_SERVER['HTTP_HOST'] .'/kamvelta_v2/views/auth/resetPassword.php?token=' . $token . '">Reset Password</a>';

            $mail->send();
            echo 'Reset link has been sent to your email address';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'No user found with that email address';
    }
}
?>


<?php
// include '../config/database.php';
// include '../models/User.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '../vendor/autoload.php';

// $database = new Database();
// $db = $database->getConnection();
// $user = new User($db);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $email = $_POST['email'];
//     $user->email = $email;
//     $token = bin2hex(random_bytes(50)); // Generate a unique token

//     if ($user->setResetToken($token)) {
//         // Send email with reset link
//         $mail = new PHPMailer(true);
//         try {
//             // Server settings
//             $mail->isSMTP();
//             $mail->Host = 'smtp.example.com'; // Your SMTP server
//             $mail->SMTPAuth = true;
//             $mail->Username = 'your-email@example.com';
//             $mail->Password = 'your-email-password';
//             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//             $mail->Port = 587;

//             // Recipients
//             $mail->setFrom('your-email@example.com', 'Your Name');
//             $mail->addAddress($email);

//             // Content
//             $mail->isHTML(true);
//             $mail->Subject = 'Password Reset Request';
//             $mail->Body = 'Click the link to reset your password: <a href="http://your-domain.com/views/auth/resetPassword.php?token=' . $token . '">Reset Password</a>';

//             $mail->send();
//             echo 'Reset link has been sent to your email address';
//         } catch (Exception $e) {
//             echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//         }
//     } else {
//         echo 'Failed to send reset link. Please try again.';
//     }
// }
?>
