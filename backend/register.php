<?php
session_start();
include "db.php";
include "../classes/register.php";


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
