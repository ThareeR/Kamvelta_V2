<?php

class ReservationItemController {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function getReservationItemsByReservationId($reservationId) {
    $query = "SELECT ri.*, rt.type_name
              FROM reservation_items ri
              LEFT JOIN room_type rt ON ri.room_type_id = rt.room_type_id
              WHERE ri.reservation_id = :reservation_id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":reservation_id", $reservationId);
    $stmt->execute();

    $reservationItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $reservationItems;
  }
}

?>