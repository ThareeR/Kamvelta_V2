<?php
class User {
    private $conn;
    private $tableName = "users";

    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new user
    public function create() {
        $query = "INSERT INTO " . $this->tableName . " (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind data
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get user by username
    public function getUserByUsername($username) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $username = htmlspecialchars(strip_tags($username));

        // Bind data
        $stmt->bindParam(":username", $username);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            return $row;
        }

        return null;
    }
}
?>
