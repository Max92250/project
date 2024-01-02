<?php


include "../classes/include.php";


$searchTerm = !empty($_GET['search']) ? $_GET['search'] : null;

$organizedData = $hobbyViewer->getOrganizedData($searchTerm);
