<?php

include "../classes/db.php";

include "../classes/soft_delete.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET["ni"];
    $hobby = $_GET["hobby"];

    $hobbyDeleter = new HobbyDeleter($con);
    $deletionSuccess = $hobbyDeleter->deleteHobby($userId, $hobby);

    if ($deletionSuccess) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    } else {
 
        echo "Error: Failed to delete hobby.";
    }
}
?>
