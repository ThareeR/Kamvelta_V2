<?php
class RoomTypeController {
    private $db;
    private $tableName = "room_type";

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->tableName . " SET type_name=:type_name, capacity=:capacity, unit_price=:unit_price, total_rooms=:total_rooms";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":type_name", $data['type_name']);
        $stmt->bindParam(":capacity", $data['capacity']);
        $stmt->bindParam(":unit_price", $data['unit_price']);
        $stmt->bindParam(":total_rooms", $data['total_rooms']);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function show($id) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE room_type_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->tableName . " SET type_name=:type_name, capacity=:capacity, unit_price=:unit_price, total_rooms=:total_rooms WHERE room_type_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":type_name", $data['type_name']);
        $stmt->bindParam(":capacity", $data['capacity']);
        $stmt->bindParam(":unit_price", $data['unit_price']);
        $stmt->bindParam(":total_rooms", $data['total_rooms']);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->tableName . " WHERE room_type_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateAvailability($roomTypeId, $bookedCount) {
        $query = "UPDATE " . $this->tableName . " SET available_rooms = available_rooms - :booked_count WHERE room_type_id = :room_type_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':booked_count', $bookedCount);
        $stmt->bindParam(':room_type_id', $roomTypeId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getMostBookedRoomType() {
        $query = "SELECT room_type_id, COUNT(*) AS count FROM reservation_items GROUP BY room_type_id ORDER BY count DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['room_type_id'];
    }
}
?>

<?php

// class RoomTypeController {

//     private $conn;

//     public $id;
//     public $type_name;
//     public $description;

//     public function __construct($db) {
//         $this->conn = $db;
//     }

//     public function getAll() {
//         $query = "SELECT * FROM room_types";
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function getById($id) {
//         $query = "SELECT * FROM room_types WHERE id = :id";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(':id', $id);
//         $stmt->execute();
//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     }

//     public function createRoomType($data) {
//         $query = "INSERT INTO room_types (type_name, description) VALUES (:type_name, :description)";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(':type_name', $data['room_type_name']);
//         $stmt->bindParam(':description', $data['description']);
//         $stmt->execute();
//     }

//     public function updateRoomType($data, $id) {
//         $query = "UPDATE room_types SET type_name = :type_name, description = :description WHERE id = :id";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(':id', $id);
//         $stmt->bindParam(':type_name', $data['room_type_name']);
//         $stmt->bindParam(':description', $data['description']);
//         $stmt->execute();
//     }

//     public function deleteRoomType($id) {
//         $query = "DELETE FROM room_types WHERE id = :id";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(':id', $id);
//         $stmt->execute();
//     }

// }

?>