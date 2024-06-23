<?php
class ReservationItem {
    private $conn;
    private $tableName = "reservation_items";

    public $reservationId;
    public $roomTypeId;
    public $roomCount;
    public $ratePerUnit;
    public $totalCharge;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->tableName . " SET reservation_id=:reservation_id, room_type_id=:room_type_id, room_count=:room_count, rate_per_unit=:rate_per_unit, total_charge=:total_charge";
        $stmt = $this->conn->prepare($query);

        $this->reservationId=htmlspecialchars(strip_tags($this->reservationId));
        $this->roomTypeId=htmlspecialchars(strip_tags($this->roomTypeId));
        $this->roomCount=htmlspecialchars(strip_tags($this->roomCount));
        $this->ratePerUnit=htmlspecialchars(strip_tags($this->ratePerUnit));
        $this->totalCharge=htmlspecialchars(strip_tags($this->totalCharge));

        $stmt->bindParam(":reservation_id", $this->reservationId);
        $stmt->bindParam(":room_type_id", $this->roomTypeId);
        $stmt->bindParam(":room_count", $this->roomCount);
        $stmt->bindParam(":rate_per_unit", $this->ratePerUnit);
        $stmt->bindParam(":total_charge", $this->totalCharge);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
