<?php

include_once(__DIR__ . '/../models/BanquetHallReservation.php');

class BanquetHallReservationController {
    private $db;
    private $banquetHallReservation;
    private $model;


    public function __construct($db) {
        $this->db = $db;
        $this->model = new BanquetHallReservation($db);
        $this->banquetHallReservation = new BanquetHallReservation($db);
    }

    public function create($reservation) {

        $this->banquetHallReservation->guest_id = $reservation->guest_id;
        $this->banquetHallReservation->hall_id = $reservation->hall_id;
        $this->banquetHallReservation->event_date = $reservation->event_date;
        $this->banquetHallReservation->start_time = $reservation->start_time;
        $this->banquetHallReservation->end_time = $reservation->end_time;
        $this->banquetHallReservation->number_of_guests = $reservation->number_of_guests;
        $this->banquetHallReservation->status = $reservation->status ?? 'pending';
        $this->banquetHallReservation->total_charge = $reservation->total_charge;

        return $this->banquetHallReservation->create();

        // $this->banquetHallReservation->guest_id = $data['guest_id'];
        // $this->banquetHallReservation->hall_id = $data['hall_id'];
        // $this->banquetHallReservation->event_date = $data['event_date'];
        // $this->banquetHallReservation->start_time = $data['start_time'];
        // $this->banquetHallReservation->end_time = $data['end_time'];
        // $this->banquetHallReservation->number_of_guests = $data['number_of_guests'];
        // $this->banquetHallReservation->status = $data['status'] ?? 'pending';
        // $this->banquetHallReservation->total_charge = $data['total_charge'];

        // return $this->banquetHallReservation->create();
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

    public function showAvailability() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hall_id = $_POST['hall_id'];
            $date = $_POST['event_date'];
            $availability = $this->model->checkAvailability($hall_id, $date);
    
            if ($availability === false) {
                echo "Error retrieving availability.";
                return;
            }
    
            $slots = [
                'morning' => 'available',
                'afternoon' => 'available',
                'evening' => 'available'
            ];
    
            foreach ($availability as $reservation) {
                $start = strtotime($reservation['start_time']);
                $end = strtotime($reservation['end_time']);
                $morning_start = strtotime('04:00:00');
                $afternoon_start = strtotime('12:30:00');
                $evening_start = strtotime('17:00:00');
    
                if ($start >= $evening_start) {
                    $slots['evening'] = 'booked';
                } elseif ($start >= $afternoon_start) {
                    if ($end <= $evening_start) {
                        $slots['afternoon'] = 'booked';
                    } else {
                        $slots['afternoon'] = 'booked';
                        $slots['evening'] = 'booked';
                    }
                } elseif ($start >= $morning_start) {
                    if ($end <= $afternoon_start) {
                        $slots['morning'] = 'booked';
                    } elseif ($end <= $evening_start) {
                        $slots['morning'] = 'booked';
                        $slots['afternoon'] = 'booked';
                    } else {
                        $slots['morning'] = 'booked';
                        $slots['afternoon'] = 'booked';
                        $slots['evening'] = 'booked';
                    }
                }
            }
            include __DIR__.'/../views/reservation/banquetHallAvailability.php';
        } else {
            include __DIR__.'/../views/reservation/banquetHallDate.php';
        }
    }
    

    public function reserve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['event_date'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $numGuests = $_POST['num_guests'];
            

            // Add reservation to the database
            $this->model->addReservation($date, $startTime, $endTime, $numGuests);

            // Show confirmation message
            include '../views/reservation/hallConfirmation.php';
        }
    }
}

    // Handle AJAX requests
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        include_once '../config/database.php';
        $database = new Database();
        $db = $database->getConnection();

        $controller = new BanquetHallReservationController($db);
        $action = $_POST['action'];

        switch ($action) {
            case 'showAvailability':
                $controller->showAvailability();
                break;
            // Add more cases for other actions if needed
        }
    }
?>
