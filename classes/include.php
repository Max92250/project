<?php
session_start();



spl_autoload_register(function ($class) {
    $classPath = 'classes/' . $class . '.php';
    if (file_exists($classPath)) {
        include $classPath;
    }
});


include("db.php");
include "home.php";
include("authenticate.php");
include("session.php");



include("user.php");
include("listdelete.php");
include("ActionHandler.php");

$action = new Action($con);


$userManagement = new UserManagement($con);
$actionHandler = new ActionHandler($con);
$hobbyViewer = new HobbyViewer($con);

$myGuestsFetcher = new MyGuestsFetcher($con);

