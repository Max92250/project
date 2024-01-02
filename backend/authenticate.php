
<?php
include "../classes/include.php";

if (isset($_POST['register'])) {
    handleRegistration($_POST['username'], $_POST['email'], $_POST['password']);
}

if (isset($_POST['submit'])) {
    handleLogin($_POST['username'], $_POST['password']);
}

function handleRegistration($username, $email, $password) {
    global $userManagement;

    $action = 'register';
    $registrationResult = $userManagement->manageUser($action, $username, $email, $password);

    if (!(is_array($registrationResult))) {
        header("location: http://localhost//project1/login.php");
        exit();
    } else {
        $_SESSION['registration_error'] = $registrationResult['message'];
        header("location: http://localhost//project1/register.php");
        exit();
    }
}

function handleLogin($username, $password) {
    global $userManagement;

    $action = 'login';
    $authenticationResult = $userManagement->manageUser($action, $username, '', $password);

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
