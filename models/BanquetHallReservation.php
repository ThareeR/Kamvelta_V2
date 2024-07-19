<?php

class BanquetHallReservation {
    private $conn;
    private $table_name = "banquet_hall_reservations";

    public $reservation_id;
    public $guest_id;
    public $hall_id;
    public $event_date;
    public $start_time;
    public $end_time;
    public $number_of_guests;
    public $status;
    public $created_at;
    public $updated_at;
    public $total_charge;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET guest_id=:guest_id, hall_id=:hall_id, event_date=:event_date, 
                      start_time=:start_time, end_time=:end_time, number_of_guests=:number_of_guests, status=:status, total_charge=:total_charge";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":guest_id", $this->guest_id);
        $stmt->bindParam(":hall_id", $this->hall_id);
        $stmt->bindParam(":event_date", $this->event_date);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":number_of_guests", $this->number_of_guests);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":total_charge", $this->total_charge);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE reservation_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->reservation_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->guest_id = $row['guest_id'];
        $this->hall_id = $row['hall_id'];
        $this->event_date = $row['event_date'];
        $this->start_time = $row['start_time'];
        $this->end_time = $row['end_time'];
        $this->number_of_guests = $row['number_of_guests'];
        $this->status = $row['status'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET guest_id = :guest_id, hall_id = :hall_id, event_date = :event_date, 
                      start_time = :start_time, end_time = :end_time, number_of_guests = :number_of_guests, status = :status 
                  WHERE reservation_id = :reservation_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":reservation_id", $this->reservation_id);
        $stmt->bindParam(":guest_id", $this->guest_id);
        $stmt->bindParam(":hall_id", $this->hall_id);
        $stmt->bindParam(":event_date", $this->event_date);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":number_of_guests", $this->number_of_guests);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":reservation_id", $this->reservation_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function isHallAvailable($hall_id, $event_date) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE hall_id = :hall_id AND event_date = :event_date";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':hall_id', $hall_id);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] == 0;
    }

}
?>
