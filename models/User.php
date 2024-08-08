<?php
class User {
    private $conn;
    private $tableName = "users";

    public $id;
    public $username;
    public $email;  //newly added
    public $password;
    public $role;
    public $reset_token;    // newly added
    public $reset_token_expiry; // newly added

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new user
    public function create() {
        $query = "INSERT INTO " . $this->tableName . " (username, password, role, email) VALUES (:username, :password, :role, :email)";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->email = htmlspecialchars(strip_tags($this->email));  // newly added

        // Bind data
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":email", $this->email);   // newly added

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
            $this->email = $row['email'];  // newly added
            $this->reset_token = $row['reset_token'];   // newly added
            $this->reset_token_expiry = $row['reset_token_expiry']; // newly added
            return $row;
        }

        return null;
    }

    // Get user by email
    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $email = htmlspecialchars(strip_tags($email));

        // Bind data
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            $this->reset_token = $row['reset_token'];
            $this->reset_token_expiry = $row['reset_token_expiry'];
            return $row;
        }

        return null;
    }

    // Update user password
    public function updatePassword($new_password) {
        $query = "UPDATE " . $this->tableName . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $new_password = htmlspecialchars(strip_tags($new_password));

        // Bind data
        $stmt->bindParam(":password", $new_password);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Set reset token
    public function setResetToken($token) {
        $query = "UPDATE " . $this->tableName . " SET reset_token = :reset_token, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(":reset_token", $token);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verify reset token
    public function verifyResetToken($token) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE reset_token = :reset_token AND reset_token_expiry > NOW() LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(":reset_token", $token);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            $this->reset_token = $row['reset_token'];
            $this->reset_token_expiry = $row['reset_token_expiry'];
            return $row;
        }

        return null;
    }
}
?>
