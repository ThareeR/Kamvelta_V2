<?php
include_once '../config/database.php';
include_once __DIR__.'/../models/Reservation.php';

class BookingController {
    private $db;
    private $reservation;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->reservation = new Reservation($this->db);
    }

    public function getBookingsByMonth() {
        $month = $_GET['month'];
        $query = "SELECT rt.type_name, COUNT(r.id) as bookings
                  FROM reservations r
                  JOIN room_type rt ON r.room_type_id = rt.room_type_id
                  WHERE MONTH(r.check_in) = :month
                  GROUP BY rt.type_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':month', $month);
        $stmt->execute();

        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        exit;
    }
}

$controller = new BookingController();
$controller->getBookingsByMonth();
?>
