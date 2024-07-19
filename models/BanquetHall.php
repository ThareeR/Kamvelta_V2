<?php

class BanquetHall {
    private $conn;
    private $table_name = "banquet_hall";

    public $hall_id;
    public $hall_name;
    public $capacity;
    public $charge_per_hour;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET hall_name=:hall_name, capacity=:capacity, charge_per_hour=:charge_per_hour";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":hall_name", $this->hall_name);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":charge_per_hour", $this->charge_per_hour);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY hall_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE hall_id = ? LIMIT 0,1";
       // $query = "SELECT hall_id, hall_name, capacity, charge_per_hour FROM " . $this->table_name . " WHERE hall_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->hall_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->hall_name = $row['hall_name'];
        $this->capacity = $row['capacity'];
        $this->charge_per_hour = $row['charge_per_hour'];
        // if ($row) {
        //     $this->hall_id = $row['hall_id'];
        //     $this->hall_name = $row['hall_name'];
        //     $this->capacity = $row['capacity'];
        //     $this->charge_per_hour = $row['charge_per_hour'];
        // }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET hall_name = :hall_name, capacity = :capacity, charge_per_hour = :charge_per_hour 
                  WHERE hall_id = :hall_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":hall_id", $this->hall_id);
        $stmt->bindParam(":hall_name", $this->hall_name);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":charge_per_hour", $this->charge_per_hour);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteReservations() {
        $query = "DELETE FROM banquet_hall_reservations WHERE hall_id = :hall_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":hall_id", $this->hall_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE hall_id = :hall_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":hall_id", $this->hall_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
