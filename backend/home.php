<?php


include "../classes/home.php";
include "db.php";
 include 'session.php';
$hobbyViewer = new HobbyViewer($con);


$searchTerm = !empty($_GET['search']) ? $_GET['search'] : null;

$organizedData = $hobbyViewer->getOrganizedData($searchTerm);
