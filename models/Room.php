<?php
class Room {
    private $conn;
    private $table_name = "rooms";

    public $room_id;
    public $room_type_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (room_type_id, status) VALUES (:room_type_id, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_type_id", $this->room_type_id);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET room_type_id = :room_type_id, status = :status WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_id", $this->room_id);
        $stmt->bindParam(":room_type_id", $this->room_type_id);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_id", $this->room_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getRoomTypeIdByRoomId($id) {
        $query = "SELECT * FROM rooms WHERE room_type_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
