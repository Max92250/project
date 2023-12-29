<?php



include "../classes/include.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET["ni"];
    $hobby = $_GET["hobby"];

    
    $deletionSuccess = $hobbyDeleter->deleteHobby($userId, $hobby);

    if ($deletionSuccess) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    } else {
 
        echo "Error: Failed to delete hobby.";
    }
}
?>
