<?php

class Payment {
    private $conn;
    private $table_name = "payments";

    public $payment_id;
    public $reservation_id;
    public $amount;
    public $payment_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (reservation_id, amount, payment_date) VALUES (:reservation_id, :amount, :payment_date)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":reservation_id", $this->reservation_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":payment_date", $this->payment_date);

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
        $query = "UPDATE " . $this->table_name . " SET reservation_id = :reservation_id, amount = :amount, payment_date = :payment_date WHERE payment_id = :payment_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":payment_id", $this->payment_id);
        $stmt->bindParam(":reservation_id", $this->reservation_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":payment_date", $this->payment_date);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE payment_id = :payment_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":payment_id", $this->payment_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getPaymentByReservationId($reservation_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":reservation_id", $reservation_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>