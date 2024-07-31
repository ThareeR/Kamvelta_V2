<?php
session_start();
include '../config/database.php';
include '../controllers/ReservationController.php';

$database = new Database();
$db = $database->getConnection();
$reservationController = new ReservationController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['payment_method'])) {
        $reservationId = $_SESSION['reservation_id'];
        $totalAmount = $_SESSION['total_charge'];  // earlier it was $_POST['total_amount']
        $paymentMethodId = $_POST['payment_method'];
        $paymentDate = date('Y-m-d H:i:s');

        $query = "INSERT INTO payments SET reservation_id=:reservation_id, payment_method_id=:payment_method_id, amount=:amount, payment_date=:payment_date";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":reservation_id", $reservationId);
        $stmt->bindParam(":payment_method_id", $paymentMethodId);
        $stmt->bindParam(":amount", $totalAmount);
        $stmt->bindParam(":payment_date", $paymentDate);

        if ($stmt->execute()) {
            $query = "UPDATE reservations SET reservation_status='confirmed' WHERE reservation_id=:reservation_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":reservation_id", $reservationId);
            $stmt->execute();

            // Send confirmation email to guest
            $guestEmail = $_SESSION['guest_email'];
            $guestFirstName = $_SESSION['guest_first_name'];
            $guestLastName = $_SESSION['guest_last_name'];
            $checkInDate = $_SESSION['check_in_date'];
            $checkOutDate = $_SESSION['check_out_date'];
            $totalCharge = $_SESSION['total_charge'];

            $to = $guestEmail;
            $subject = 'Reservation Confirmation';
            $headers = "From: rasithharie@gmail.com\r\n";
            $headers .= "Reply-To: rasithharie@gmail.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = '
            <html>
            <head>
                <title>Reservation Confirmation</title>
            </head>
            <body>
                <p>Dear ' . htmlspecialchars($guestFirstName) . ' ' . htmlspecialchars($guestLastName) . ',</p>
                <p>Thank you for your reservation. Your reservation ID is ' . htmlspecialchars($reservationId) . '.</p>
                <p>Check-in Date: ' . htmlspecialchars($checkInDate) . '</p>
                <p>Check-out Date: ' . htmlspecialchars($checkOutDate) . '</p>
                <p>Total Charge: ' . htmlspecialchars($totalCharge) . '</p>
                <p>We look forward to your stay.</p>
            </body>
            </html>';

            mail($to, $subject, $message, $headers);

            header('Location: ../views/reservation/reservationConfirm.php');
            exit();
        } else {
            echo "Payment failed and could not send an email.";
        }
    }
}
?>
