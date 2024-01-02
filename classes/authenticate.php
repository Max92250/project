<?php

class UserManagement {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function manageUser($action, $username, $email, $password) {
        switch ($action) {
            case 'register':
                return $this->registerUser($username, $email, $password);
            case 'login':
                return $this->authenticateUser($username, $password);
            default:
                return ['status' => 'error', 'message' => 'Invalid action.'];
        }
    }

    private function isUsernameTaken($username) {
        $sql = "SELECT * FROM MyGuests WHERE firstname = ?";
        $stmt = $this->con->executePreparedStatement($sql, 's', $username);
        if (!$stmt) {
            return false;
        }

        return $this->con->checkIfRowsExist($stmt);
    }

    private function insertUserIntoDatabase($username, $email, $password) {
        $hashedPassword = md5($password);
        $sql = "INSERT INTO MyGuests (firstname, email, password) VALUES (?, ?, ?)";
        $stmt = $this->con->executePreparedStatement($sql, 'sss', $username, $email, $hashedPassword);

        return $this->con->fetch_id($stmt);
    }

    private function registerUser($username, $email, $password) {
        if ($this->isUsernameTaken($username)) {
            return ['status' => 'error', 'message' => 'Username already taken'];
        } else {
            return $this->insertUserIntoDatabase($username, $email, $password);
        }
    }

    private function authenticateUser($username,$password) {
        $hashedPassword = md5($password);
        $sql = "SELECT * FROM MyGuests WHERE firstname = ?";
        $stmt = $this->con->executePreparedStatement($sql, "s", $username);
        if (is_array($stmt)) {
            return ['status' => 'error', 'message' => 'Failed to authenticate user.'];
        }

        $row = $this->con->fetch_assoc($stmt);

        if ($row && ($hashedPassword ==  $row['password'])) {
            return $this->con->fetch_id($stmt);
        } else {
            return ['status' => 'error', 'message' => 'Incorrect username or password!'];
        }
    }
}

