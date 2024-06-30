<?php
class RoomType {
    private $conn;
    private $tableName = "room_type";

    public $roomTypeId;
    public $typeName;
    public $capacity;
    public $unitPrice;
    public $totalRooms;
    public $availableRooms;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateAvailability($roomTypeId, $bookedCount) {
        $query = "UPDATE " . $this->tableName . " SET available_rooms = available_rooms - :booked_count WHERE room_type_id = :room_type_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':booked_count', $bookedCount);
        $stmt->bindParam(':room_type_id', $roomTypeId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

        public function updateCount($roomTypeId, $increment) {
            $query = "UPDATE room_type SET total_rooms = total_rooms + :increment WHERE room_type_id = :roomTypeId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":increment", $increment);
            $stmt->bindParam(":roomTypeId", $roomTypeId);
            $stmt->execute();
        }
}
?>
