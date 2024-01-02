
<?php


include "../classes/include.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = '';
    $password = $_POST['password'];
    $action = 'login';
    $authenticationResult = $userManagement->manageUser($action,$username,$email, $password);
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