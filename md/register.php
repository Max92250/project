<?php

include "../classes/include.php";

if (isset($_POST['register'])) {
    $action = 'register';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $registrationResult = $userManagement->manageUser($action,$username, $email, $password);

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
