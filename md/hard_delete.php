
<?php
include "../classes/include.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET["ni"];
    $hobbyId = $_GET["hobby_id"];

    $deletionResult = $actionHandler->performAction('hardDeleteHobby', $userId, $hobbyId);
    if ($deletionResult) {
        header("location: http://localhost/project1/details/home.php");
    } else {
        
        echo "Error: Failed to delete hobby.";
    }

} else {
    echo "Invalid request method";
}