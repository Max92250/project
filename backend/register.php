<?php
session_start();
include "db.php";

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
  
        $result = $stmt->get_result();


        return mysqli_num_rows($result) > 0;
    }

    private function insertUserIntoDatabase($username, $email, $password) {
        $hashedPassword = md5($password);
        $sql = "INSERT INTO MyGuests (firstname, email, password) VALUES (?, ?, ?)";
        $stmt = $this->con->executePreparedStatement($sql, 'sss', $username, $email, $hashedPassword);
       
        return $stmt->insert_id;
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $registration = new Registration($con);
    $registrationResult = $registration->registerUser($username, $email, $password);

    if (!(is_array($registrationResult))) {
        header("location: http://localhost//project1/login.php");
        exit();
    } else {
        $_SESSION['registration_error'] = $registrationResult['message'];
        header("location: http://localhost//project1/register.php");
        exit();
    }
}
?>
