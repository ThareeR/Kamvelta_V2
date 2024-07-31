<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/../assets/PHPMailer-master/src/Exception.php';
require __DIR__.'/../assets/PHPMailer-master/src/PHPMailer.php';
require __DIR__.'/../assets/PHPMailer-master/src/SMTP.php';

// include_once '../models/Guest.php';
include_once(__DIR__ . '/../models/Guest.php');
include_once(__DIR__ . '/../models/Reservation.php');
include_once(__DIR__ . '/../models/ReservationItem.php');
include_once(__DIR__ . '/../models/RoomType.php');
// include_once '../models/Reservation.php';
// include_once '../models/ReservationItem.php';
// include_once '../models/RoomType.php';

class ReservationController {
    private $db;
    private $guest;
    private $reservation;
    private $reservationItem;
    private $roomType;

    public function __construct($db) {
        $this->db = $db;
        $this->guest = new Guest($db);
        $this->reservation = new Reservation($db);
        $this->reservationItem = new ReservationItem($db);
        $this->roomType = new RoomType($db);
    }

    public function createReservation($guestData, $reservationData, $reservationItems) {
        $this->guest->nic = $guestData['nic'];

        if (!$this->guest->getGuestByNic($guestData['nic'])) {
            $this->guest->nic = $guestData['nic'];
            $this->guest->firstName = $guestData['first_name'];
            $this->guest->lastName = $guestData['last_name'];
            $this->guest->contactNumber = $guestData['contact_number'];
            $this->guest->email = $guestData['email'];
            $this->guest->homeAddress = $guestData['home_address'];
            $this->guest->create();
        }

        $this->guest->getGuestByNic($guestData['nic']);
        $guestId = $this->guest->id;

        $this->reservation->guestId = $guestId;
        $this->reservation->bookingDate = date('Y-m-d H:i:s');
        $this->reservation->checkInDate = $reservationData['check_in_date'];
        $this->reservation->checkOutDate = $reservationData['check_out_date'];
        $this->reservation->reservationStatus = 'pending';
        $reservationId = $this->reservation->create();

        if ($reservationId) {
            foreach ($reservationItems as $item) {
                $this->reservationItem->reservationId = $reservationId;
                $this->reservationItem->roomTypeId = $item['room_type_id'];
                $this->reservationItem->roomCount = $item['room_count'];
                $this->reservationItem->ratePerUnit = $item['rate_per_unit'];
                $this->reservationItem->totalCharge = $item['total_charge'];
                $this->reservationItem->create();

                $this->roomType->updateAvailability($item['room_type_id'], $item['room_count']);
            }

            // Send confirmation email to guest using PHP mail() function
            // $to = $guestData['email'];
            // $subject = 'Reservation Confirmation';
            // $headers = "From: rasithharie@gmail.com\r\n";
            // $headers .= "Reply-To: rasithharie@gmail.com\r\n";
            // $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // $message = '
            // <html>
            // <head>
            //     <title>Reservation Confirmation</title>
            // </head>
            // <body>
            //     <p>Dear ' . $guestData['first_name'] . ' ' . $guestData['last_name'] . ',</p>
            //     <p>Thank you for your reservation. Your reservation ID is ' . $reservationId . '.</p>
            //     <p>Check-in Date: ' . $reservationData['check_in_date'] . '</p>
            //     <p>Check-out Date: ' . $reservationData['check_out_date'] . '</p>
            //     <p>Total Charge: ' . $reservationData['total_charge'] . '</p>
            //     <p>We look forward to your stay.</p>
            // </body>
            // </html>';

            // if (mail($to, $subject, $message, $headers)) {
            //     echo 'Reservation successful and email sent.';
            // } else {
            //     echo 'Reservation successful but email could not be sent.';
            // } 

            return $reservationId;
        }
        return false;
    }

    public function checkAvailability($checkInDate, $checkOutDate) {
        $query = "SELECT rt.*, (rt.available_rooms - COALESCE(SUM(ri.room_count), 0)) AS available_rooms 
                  FROM room_type rt 
                  LEFT JOIN reservations r ON r.check_in_date <= :check_out_date AND r.check_out_date >= :check_in_date AND r.reservation_status = 'confirmed'
                  LEFT JOIN reservation_items ri ON r.reservation_id = ri.reservation_id AND ri.room_type_id = rt.room_type_id 
                  GROUP BY rt.room_type_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':check_in_date', $checkInDate);
        $stmt->bindParam(':check_out_date', $checkOutDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT * FROM reservations";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id) {
        $query = "SELECT * FROM reservations WHERE reservation_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM reservations WHERE guest_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $query = "DELETE FROM guests WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
        }

    public function update($id, $data) {
        $query = "UPDATE reservations SET guest_id = :guest_id, 
        check_in_date = :check_in_date, check_out_date = :check_out_date, 
        reservation_status = :reservation_status WHERE reservation_id = :id";
        $stmt = $this->db->prepare($query);
        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':guest_id', $data['guest_id']);
        $stmt->bindParam(':check_in_date', $data['check_in_date']);
        $stmt->bindParam(':check_out_date', $data['check_out_date']);
        $stmt->bindParam(':reservation_status', $data['reservation_status']);
        if ($stmt->execute()) {
        return true;
        }
    }
    
    // Add new function to get all reservations
    public function getAllReservations() {
        $query = "SELECT * FROM reservations";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new function to get reservations by status
    public function getReservationsByStatus($status) {
        $query = "SELECT * FROM reservations WHERE reservation_status = :status";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationsByGuestId($guestId) {
        $query = "SELECT * FROM reservations WHERE guest_id = :guest_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":guest_id", $guestId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!--22/6 -->
<?php
// class ReservationController {
//     private $conn;
//     private $tableName = "reservations";

//     public function __construct($db) {
//         $this->conn = $db;
//     }

//     public function checkAvailability($checkInDate, $checkOutDate) {
//         $query = "SELECT rt.*, (rt.available_rooms - COALESCE(SUM(ri.room_count), 0)) AS available_rooms 
//             FROM room_type rt 
//             LEFT JOIN reservations r ON r.check_in_date <= :check_out_date AND r.check_out_date >= :check_in_date AND r.reservation_status = 'confirmed'
//             LEFT JOIN reservation_items ri ON r.reservation_id = ri.reservation_id AND ri.room_type_id = rt.room_type_id 
//             GROUP BY rt.room_type_id";
//         $stmt = $this->conn->prepare($query);
        
//             $stmt->bindParam(':check_in_date', $checkInDate);
//             $stmt->bindParam(':check_out_date', $checkOutDate);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function createReservation($data) {
//         $query = "INSERT INTO " . $this->tableName . " (guest_id, booking_date, check_in_date, check_out_date, reservation_status) VALUES (:guest_id, NOW(), :check_in, :check_out, :status)";
//         $stmt = $this->conn->prepare($query);

//         $stmt->bindParam(':guest_id', $data['guest_id']);
//         $stmt->bindParam(':check_in', $data['check_in']);
//         $stmt->bindParam(':check_out', $data['check_out']);
//         $stmt->bindParam(':status', $data['status']);
//        // $stmt->bindParam(':total_charge', $data['total_charge']);

//         if ($stmt->execute()) {
//             return $this->conn->lastInsertId();
//         }
//         return false;
//     }

//     public function createReservationItem($data) {
//         $query = "INSERT INTO reservation_items (reservation_id, room_type_id, room_count, rate_per_unit, total_charge) VALUES (:reservation_id, :room_type_id, :room_count, :rate_per_unit, :total_charge)";
//         $stmt = $this->conn->prepare($query);

//         $stmt->bindParam(':reservation_id', $data['reservation_id']);
//         $stmt->bindParam(':room_type_id', $data['room_type_id']);
//         $stmt->bindParam(':room_count', $data['room_count']);
//         $stmt->bindParam(':rate_per_unit', $data['rate_per_unit']);
//         $stmt->bindParam(':total_charge', $data['total_charge']);

//         return $stmt->execute();
//     }
//}
?>

