<?php


include "../classes/home.php";
include "../classes/db.php";
 include '../classes/session.php';
$hobbyViewer = new HobbyViewer($con);


$searchTerm = !empty($_GET['search']) ? $_GET['search'] : null;

$organizedData = $hobbyViewer->getOrganizedData($searchTerm);
