<?php
include_once '../models/Guest.php';
include_once '../models/Reservation.php';
include_once '../models/ReservationItem.php';
include_once '../models/RoomType.php';

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

