<?php

include_once(__DIR__ . '/../models/BanquetHallReservation.php');

class BanquetHallReservationController {
    private $db;
    private $banquetHallReservation;

    public function __construct($db) {
        $this->db = $db;
        $this->banquetHallReservation = new BanquetHallReservation($db);
    }

    public function create($data) {
        $this->banquetHallReservation->guest_id = $data['guest_id'];
        $this->banquetHallReservation->hall_id = $data['hall_id'];
        $this->banquetHallReservation->event_date = $data['event_date'];
        $this->banquetHallReservation->start_time = $data['start_time'];
        $this->banquetHallReservation->end_time = $data['end_time'];
        $this->banquetHallReservation->number_of_guests = $data['number_of_guests'];
        $this->banquetHallReservation->status = $data['status'] ?? 'pending';
        $this->banquetHallReservation->total_charge = $data['total_charge'];

        return $this->banquetHallReservation->create();
    }

    public function getAll() {
        return $this->banquetHallReservation->readAll()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($reservation_id) {
        $this->banquetHallReservation->reservation_id = $reservation_id;
        $this->banquetHallReservation->readOne();
        return $this->banquetHallReservation;
    }

    public function update($data) {
        $this->banquetHallReservation->reservation_id = $data['reservation_id'];
        $this->banquetHallReservation->guest_id = $data['guest_id'];
        $this->banquetHallReservation->hall_id = $data['hall_id'];
        $this->banquetHallReservation->event_date = $data['event_date'];
        $this->banquetHallReservation->start_time = $data['start_time'];
        $this->banquetHallReservation->end_time = $data['end_time'];
        $this->banquetHallReservation->number_of_guests = $data['number_of_guests'];
        $this->banquetHallReservation->status = $data['status'];
        $this->banquetHallReservation->total_charge = $data['total_charge'];

        return $this->banquetHallReservation->update();
    }

    public function delete($reservation_id) {
        $this->banquetHallReservation->reservation_id = $reservation_id;
        return $this->banquetHallReservation->delete();
    }

    public function isHallAvailable($hall_id, $event_date) {
        $banquetHallReservation = new BanquetHallReservation($this->db);
        return $banquetHallReservation->isHallAvailable($hall_id, $event_date);
    }
}
?>
