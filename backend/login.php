
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
        $sql = "SELECT * FROM MyGuests WHERE firstname = ?";
        $stmt = $this->con->executePreparedStatement($sql, "s", $username);

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();


        if ($row && ($hashedPassword ==  $row['password'])) {
            return $stmt->insert_id;
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

    if (!(is_array($authenticationResult))) {
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