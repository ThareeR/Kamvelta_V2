<?php
session_start();
include '../config/database.php';
include '../controllers/ReservationController.php';

$database = new Database();
$db = $database->getConnection();
$reservationController = new ReservationController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nic']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['contact_number']) && isset($_POST['email']) && isset($_POST['home_address'])) {
        $guestData = [
            'nic' => $_POST['nic'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'contact_number' => $_POST['contact_number'],
            'email' => $_POST['email'],
            'home_address' => $_POST['home_address']
        ];

        $reservationData = [
            'check_in_date' => $_SESSION['check_in_date'],
            'check_out_date' => $_SESSION['check_out_date'],
            'total_charge' => $_SESSION['total_charge']
        ];

        $reservationItems = $_SESSION['reservation_items'];

        $reservationId = $reservationController->createReservation($guestData, $reservationData, $reservationItems);

        if ($reservationId) {
            // $_SESSION['reservation_id'] = $reservationId;
            $_SESSION['reservation_id'] = $reservationId;
            $_SESSION['guest_email'] = $guestData['email'];
            $_SESSION['guest_first_name'] = $guestData['first_name'];
            $_SESSION['guest_last_name'] = $guestData['last_name'];
            $_SESSION['total_charge'] = $reservationData['total_charge'];
            header('Location: ../views/reservation/payment.php');
            exit();
        } else {
            echo "Reservation failed.";
        }
    } 
    // elseif (isset($_POST['payment_method'])) {
    //     $reservationId = $_SESSION['reservation_id'];
    //     $totalAmount = $_SESSION['total_amount'];
    //     $paymentMethodId = $_POST['payment_method'];
    //     $paymentDate = date('Y-m-d H:i:s');

    //     $query = "INSERT INTO payments SET reservation_id=:reservation_id, payment_method_id=:payment_method_id, amount=:amount, payment_date=:payment_date";
    //     $stmt = $db->prepare($query);

    //     $stmt->bindParam(":reservation_id", $reservationId);
    //     $stmt->bindParam(":payment_method_id", $paymentMethodId);
    //     $stmt->bindParam(":amount", $totalAmount);
    //     $stmt->bindParam(":payment_date", $paymentDate);

    //     if ($stmt->execute()) {
    //         $query = "UPDATE reservations SET reservation_status='confirmed' WHERE reservation_id=:reservation_id";
    //         $stmt = $db->prepare($query);
    //         $stmt->bindParam(":reservation_id", $reservationId);
    //         $stmt->execute();

    //         // echo "Reservation confirmed.";
    //         header('Location: ../views/reservation/reservationConfirm.php');
    //     } else {
    //         echo "Payment failed.";
    //     }
    //}
}
?>
