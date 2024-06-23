<?php
class AdminController {
    private $db;
    private $guest;
    private $reservation;
    private $roomType;

    public function __construct($db) {
        $this->db = $db;
        $this->guest = new Guest($db);
        $this->reservation = new Reservation($db);
        $this->roomType = new RoomType($db);
    }

    public function getAllGuests() {
        return $this->guest->getAll();
    }

    public function getAllReservations() {
        return $this->reservation->getAll();
    }

    public function getAllRoomTypes() {
        return $this->roomType->getAll();
    }
}
?>
