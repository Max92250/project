
<?php

session_start();
include "db.php";

class Authentication {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function authenticateUser($username, $password) {
        $hashedPassword = md5($password);
        $stmt = $this->con->prepare("SELECT * FROM MyGuests WHERE firstname = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && ($hashedPassword ==  $row['password'])) {
            return ['status' => 'success', 'message' => 'Login successful'];
        } else {
            return ['status' => 'error', 'message' => 'Incorrect username or password!'];
        }
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authentication = new Authentication($con);
    $authenticationResult = $authentication->authenticateUser($username, $password);

    if ($authenticationResult['status'] === 'success') {
        $_SESSION['user'] = $username;
        header("location: http://localhost//project1/details/home.php");
        exit();
    } else {
        $_SESSION['credentials'] = $authenticationResult['message'];
        header("location: http://localhost//project1/login.php");
        exit();
    }
}
?>