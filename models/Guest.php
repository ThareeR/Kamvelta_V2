<?php
class Guest {
    private $conn;
    private $tableName = "guests";

    public $id;
    public $nic;
    public $firstName;
    public $lastName;
    public $contactNumber;
    public $email;
    public $homeAddress;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->tableName . " SET nic=:nic, first_name=:first_name, last_name=:last_name, contact_number=:contact_number, email=:email, home_address=:home_address";
        $stmt = $this->conn->prepare($query);

        $this->nic=htmlspecialchars(strip_tags($this->nic));
        $this->firstName=htmlspecialchars(strip_tags($this->firstName));
        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
        $this->contactNumber=htmlspecialchars(strip_tags($this->contactNumber));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->homeAddress=htmlspecialchars(strip_tags($this->homeAddress));

        $stmt->bindParam(":nic", $this->nic);
        $stmt->bindParam(":first_name", $this->firstName);
        $stmt->bindParam(":last_name", $this->lastName);
        $stmt->bindParam(":contact_number", $this->contactNumber);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":home_address", $this->homeAddress);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getGuestByNic($nic) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE nic = :nic LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nic', $nic);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->nic = $row['nic'];
            $this->firstName = $row['first_name'];
            $this->lastName = $row['last_name'];
            $this->contactNumber = $row['contact_number'];
            $this->email = $row['email'];
            $this->homeAddress = $row['home_address'];
            return true;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // From Kamvelta_version1

    // public function show($id) {
    //     $query = "SELECT * FROM guests WHERE id = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(1, $id);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // public function update($id, $data) {
    //     $query = "UPDATE guests SET nic = :nic, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, home_address = :home_address WHERE id = :id";
    //     $stmt = $this->conn->prepare($query);

    //     // Bind parameters
    //     $stmt->bindParam(':id', $id);
    //     $stmt->bindParam(':nic', $data['nic']);
    //     $stmt->bindParam(':first_name', $data['first_name']);
    //     $stmt->bindParam(':last_name', $data['last_name']);
    //     $stmt->bindParam(':contact_number', $data['contact_number']);
    //     $stmt->bindParam(':email', $data['email']);
    //     $stmt->bindParam(':home_address', $data['home_address']);

    //     if ($stmt->execute()) {
    //         return true;
    //     } 
    //     //else {
    //         //return false;
    //     //}
    // }

    // public function delete($id) {
    //     $query = "DELETE FROM reservations WHERE guest_id = :id";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(":id", $id);
    //     $stmt->execute();

    //     $query = "DELETE FROM guests WHERE id = :id";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(":id", $id);
    //     return $stmt->execute();
    // }
}
?>
