<?php
include_once '../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new \User($db);
    }

    public function register($username, $password, $role) {
        $this->user->username = $username;
        $this->user->password = password_hash($password, PASSWORD_BCRYPT);
        $this->user->role = $role;

        if ($this->user->create()) {
            return true;
        }
        return false;
    }

    public function login($username, $password, &$session) {
        $user = $this->user->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $session['user_id'] = $user['id'];
            $session['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header('Location: ../views/dashboard/adminDashboard.php');
            } elseif ($user['role'] == 'customer') {
                header('Location: ../views/dashboard/customerDashboard.php');
            }
            //exit;
        }
        return false;
    }

}
?>
