<?php

// Added later
include_once __DIR__.'/../config/database.php';
include_once __DIR__.'/../models/Guest.php';
// ----

class GuestController {
    private $db;
    private $guest; // ----

    public function __construct($db) {
        $this->db = $db;
        $this->guest = new Guest($db); // This line was added when implementing hall booking
    }

    public function index() {
        $query = "SELECT * FROM guests";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO guests (nic, first_name, last_name, contact_number, email, home_address) VALUES (:nic, :first_name, :last_name, :contact_number, :email, :home_address)";
        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':nic', $data['nic']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':contact_number', $data['contact_number']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':home_address', $data['home_address']);

        if ($stmt->execute()) {
            return true;
         } 
         //else {
        //     return false;
        // }
    }

    public function show($id) {
        $query = "SELECT * FROM guests WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE guests SET nic = :nic, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, home_address = :home_address WHERE id = :id";
        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nic', $data['nic']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':contact_number', $data['contact_number']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':home_address', $data['home_address']);

        if ($stmt->execute()) {
            return true;
        } 
        //else {
            //return false;
        //}
    }

    public function delete($id) {

        $query = "SELECT reservation_id FROM reservations WHERE guest_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $reservationIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($reservationIds as $reservationId) {
            $query = "DELETE FROM reservation_items WHERE reservation_id = :reservation_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":reservation_id", $reservationId);
            $stmt->execute();
        }

        $query = "DELETE FROM reservations WHERE guest_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $query = "DELETE FROM guests WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // This is added for Hall Reservations
    public function getByNIC($nic) {
        $this->guest->nic = $nic;
        if ($this->guest->getGuestByNic($nic)) {
            // return $this->guest->getGuestByNic($nic);
            $query = "SELECT * FROM " . 'guests' . " WHERE nic = :nic LIMIT 0,1";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':nic', $nic);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // $this->guest = $row;
            // return $this->guest;
            return $row;

        }
        return null;
    }

    public function search($searchQuery) {
        $query = "SELECT * FROM guests WHERE first_name LIKE :search OR last_name LIKE :search OR nic LIKE :search";
        $stmt = $this->db->prepare($query);
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcards for LIKE query
        $stmt->bindParam(':search', $searchQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>

<!-- This following part was already commented before -->

<?php
// class GuestController {
//     private $db;
//     private $guest;

//     public function __construct($db) {
//         $this->db = $db;
//         $this->guest = new Guest($db);
//     }

//     public function getAllGuests() {
//         return $this->guest->getAll();
//     }

//     public function createGuest($guestData) {
//         $this->guest->nic = $guestData['nic'];
//         $this->guest->firstName = $guestData['first_name'];
//         $this->guest->lastName = $guestData['last_name'];
//         $this->guest->contactNumber = $guestData['contact_number'];
//         $this->guest->email = $guestData['email'];
//         $this->guest->homeAddress = $guestData['home_address'];

//         return $this->guest->create();
//     }

//     public function updateGuest($guestData) {
//         $this->guest->id = $guestData['id'];
//         $this->guest->nic = $guestData['nic'];
//         $this->guest->firstName = $guestData['first_name'];
//         $this->guest->lastName = $guestData['last_name'];
//         $this->guest->contactNumber = $guestData['contact_number'];
//         $this->guest->email = $guestData['email'];
//         $this->guest->homeAddress = $guestData['home_address'];

//         return $this->guest->update();
//     }
// }
?>

<!--22/6 -->
<?php
// class GuestController {
//     private $conn;
//     private $tableName = "guests";

//     public function __construct($db) {
//         $this->conn = $db;
//     }

//     public function getGuestIdByNIC($nic) {
//         $query = "SELECT id FROM " . $this->tableName . " WHERE nic = :nic";
//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(':nic', $nic);
//         $stmt->execute();

//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         return $row ? $row['id'] : false;
//     }

//     public function createGuest($data) {
//         $query = "INSERT INTO " . $this->tableName . " (nic, first_name, last_name, contact_number, email, home_address) VALUES (:nic, :first_name, :last_name, :contact_number, :email, :home_address)";
//         $stmt = $this->conn->prepare($query);

//         $stmt->bindParam(':nic', $data['nic']);
//         $stmt->bindParam(':first_name', $data['first_name']);
//         $stmt->bindParam(':last_name', $data['last_name']);
//         $stmt->bindParam(':contact_number', $data['contact_number']);
//         $stmt->bindParam(':email', $data['email']);
//         $stmt->bindParam(':home_address', $data['home_address']);

//         if ($stmt->execute()) {
//             return $this->conn->lastInsertId();
//         }
//         return false;
//     }
// }
?>
