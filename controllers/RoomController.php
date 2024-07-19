<?php
require_once __DIR__. '/../models/Room.php';
require_once __DIR__. '/../models/RoomType.php';

class RoomController {
    private $db;
    private $room;

    public function __construct($db) {
        $this->db = $db;
        $this->room = new Room($db);
    }

    public function createRoom($data) {
    //     $this->room->room_type_id = $data['room_type_id'];
    //     $this->room->status = $data['status'];
    //    // return $this->room->create();
    //    $result = $this->room->create();

        $query = "INSERT INTO rooms (room_type_id, status) VALUES (:room_type_id, :status)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':room_type_id', $data['room_type_id']);
        $stmt->bindParam(':status', $data['status']);

        // Update the total rooms count for the room type
        $roomTypeId = $data['room_type_id'];
        $this->updateRoomTypeCount($roomTypeId, 1); // increment by 1

        if($stmt->execute()){
            return true;
        }

        // return $result;
    }

    public function readAllRooms() {
        return $this->room->readAll()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRoom($id, $data) {
        $this->room->room_id = $id;
        $this->room->room_type_id = $data['room_type_id'];
        $this->room->status = $data['status'];
        return $this->room->update();
    }

    public function deleteRoom($id) {
        $this->room->room_id = $id;
        return $this->room->delete();

        // Update the total rooms count for the room type
        $roomTypeId = $this->room->getRoomTypeIdByRoomId($id);
        $result = $this->updateRoomTypeCount($roomTypeId, -1); // decrement by 1

        return $result;
    }

    private function updateRoomTypeCount($roomTypeId, $increment) {
        // Assume you have a RoomType model with a method to update the count
        $roomTypeModel = new RoomType($this->db);
        $roomTypeModel->updateCount($roomTypeId, $increment);
    }

    public function show($id) {
        try {
            $query = "SELECT * FROM rooms WHERE room_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                throw new Exception("Room not found");
            }
        } catch (PDOException $e) {
            throw new Exception("Error fetching room: " . $e->getMessage());
        }
    }
}
?>



<?php

//include_once '../config/Database.php';
//include_once '../models/Room.php';

// class RoomController {
//     private $conn;
//     private $room;

//     public function __construct($db) {
//         $this->conn = $db;
//         //$this->room = new Room($db);
//     }

//     public function getAll() {
//         //return $this->room->getAll();
//         $query = "SELECT * FROM rooms";
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function show($id) {
//         $query = "SELECT * FROM rooms WHERE room_type_id = :id";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(":id", $id);
//         $stmt->execute();
//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     }

//     public function create($roomTypeId, $roomId, $status) {
//         $this->room->roomTypeId = $roomTypeId;
//         $this->room->roomId = $roomId;
//         $this->room->status = $status;
//         return $this->room->create();
//     }

//     public function delete($id) {
//         $this->room->id = $id;
//         return $this->room->delete();
//     }
// }
?>
