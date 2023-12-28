
<?php

session_start();
include "../classes/db.php";
include "../classes/login.php";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authentication = new Authentication($con);
    $authenticationResult = $authentication->authenticateUser($username, $password);

    if (isset($authenticationResult['status']) && $authenticationResult['status'] === 'error') {
        $_SESSION['credentials'] = $authenticationResult['message'];
        header("location: http://localhost/project1/login.php");
        exit();
    } else {
        $_SESSION['user'] = $username;
        header("location: http://localhost/project1/details/home.php");
        exit();
    }
}
?>