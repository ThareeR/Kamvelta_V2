<?php

// include_once '../config/database.php';
include_once __DIR__.'/../models/BanquetHall.php';

class BanquetHallController {
    private $db;
    private $banquetHall;

    public function __construct($db) {
        $this->db = $db;
        $this->banquetHall = new BanquetHall($db);
    }

    public function index() {
        $stmt = $this->banquetHall->readAll();
        $halls = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $halls;
    }

    public function create($data) {
        $this->banquetHall->hall_name = $data['hall_name'];
        $this->banquetHall->capacity = $data['capacity'];
        $this->banquetHall->charge_per_hour = $data['charge_per_hour'];

        return $this->banquetHall->create();
    }

    public function getAll() {
        $stmt = $this->banquetHall->read();
        $halls = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $halls;
    }

    public function getOne($hall_id) {

        // $query = "SELECT * FROM ". 'banquet_hall'. " WHERE hall_id =? LIMIT 0,1";

        // $stmt = $this->db->prepare($query);
        // $stmt->bindParam(1, $hall_id);
        // $stmt->execute();
    
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // return $row;
        $this->banquetHall->hall_id = $hall_id;
        $this->banquetHall->readOne();
        return $this->banquetHall;
    }

    public function update($data) {
        $this->banquetHall->hall_id = $data['hall_id'];
        $this->banquetHall->hall_name = $data['hall_name'];
        $this->banquetHall->capacity = $data['capacity'];
        $this->banquetHall->charge_per_hour = $data['charge_per_hour'];

        return $this->banquetHall->update();
    }

    public function delete($hall_id) {
        // $this->banquetHall->hall_id = $hall_id;
        // return $this->banquetHall->delete();
        $banquetHall = new BanquetHall($this->db);
        $banquetHall->hall_id = $hall_id;
        if ($banquetHall->deleteReservations()) {
            return $banquetHall->delete();
        }
        return false;
    }

    public function read($id) {
        $this->banquetHall->hall_id = $id;
        $this->banquetHall->readOne();
        return [
            'hall_id' => $this->banquetHall->hall_id,
            'hall_name' => $this->banquetHall->hall_name,
            'capacity' => $this->banquetHall->capacity,
            'charge_per_hour' => $this->banquetHall->charge_per_hour
        ];
    }
}
?>
