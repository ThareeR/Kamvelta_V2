<?php
class Reservation {
    private $conn;
    private $tableName = "reservations";

    public $reservationId;
    public $guestId;
    public $bookingDate;
    public $checkInDate;
    public $checkOutDate;
    public $reservationStatus;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->tableName . " SET guest_id=:guest_id, booking_date=:booking_date, check_in_date=:check_in_date, check_out_date=:check_out_date, reservation_status=:reservation_status";
        $stmt = $this->conn->prepare($query);

        $this->guestId=htmlspecialchars(strip_tags($this->guestId));
        $this->bookingDate=htmlspecialchars(strip_tags($this->bookingDate));
        $this->checkInDate=htmlspecialchars(strip_tags($this->checkInDate));
        $this->checkOutDate=htmlspecialchars(strip_tags($this->checkOutDate));
        $this->reservationStatus=htmlspecialchars(strip_tags($this->reservationStatus));

        $stmt->bindParam(":guest_id", $this->guestId);
        $stmt->bindParam(":booking_date", $this->bookingDate);
        $stmt->bindParam(":check_in_date", $this->checkInDate);
        $stmt->bindParam(":check_out_date", $this->checkOutDate);
        $stmt->bindParam(":reservation_status", $this->reservationStatus);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
