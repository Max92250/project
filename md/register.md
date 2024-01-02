<?php
class Registration {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function registerUser($username, $email, $password) {
        if ($this->isUsernameTaken($username)) {
            return ['status' => 'error', 'message' => 'Username already taken'];
        } else {
            return $this->insertUserIntoDatabase($username, $email, $password);
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
}