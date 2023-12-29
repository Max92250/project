<?php



include "form.php";
include("db.php");
include "home.php";
include "login.php";
include("register.php");
include("session.php");
include("soft_delete.php");
include("hubbyupdate.php");
include("hard_delete.php");




$listAdder = new ListAdder($con);
$authentication = new Authentication($con);
$registration = new Registration($con);
$hobbyViewer = new HobbyViewer($con);
$hobbyDeleter = new HobbyDeleter($con);
$hobbyUpdater = new HobbyUpdater($con);
$hobbyDeleter = new HobbyDeleter($con);

