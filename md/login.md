<?php

class Authentication {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function authenticateUser($username, $password) {
        $hashedPassword = md5($password);
        $sql = "SELECT * FROM MyGuests WHERE firstname = ?";
        $stmt = $this->con->executePreparedStatement($sql, "s", $username);
        if (is_array($stmt)) {
            // Handle the error, for example:
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