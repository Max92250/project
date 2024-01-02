<?php
include "../classes/include.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (isset($_GET["ni"]) && isset($_GET["hobby"])) {
        $userId = $_GET["ni"];
        $hobby = $_GET["hobby"];

        $deletionSuccess = $actionHandler->performAction('deleteHobby', $userId, $hobby);

        if ($deletionSuccess) {
            header("location: http://localhost/project1/details/home.php");
            exit();
        } else {
            echo "Error: Failed to delete hobby.";
        }
    } elseif (isset($_GET['id'])) {
        
        $userId = $_GET['id'];

        $deletionResult = $actionHandler->performAction('deleteList', $userId);

        if ($deletionResult) {
            header("location: http://localhost/project1/details/home.php");
        } else {
            echo "Error: Failed to delete list item.";
        }
    } elseif (isset($_GET["ni"]) && isset($_GET["hobby_id"])) {
        $userId = $_GET["ni"];
        $hobbyId = $_GET["hobby_id"];

        $deletionResult = $actionHandler->performAction('hardDeleteHobby', $userId, $hobbyId);

        if ($deletionResult) {
            header("location: http://localhost/project1/details/home.php");
        } else {
            echo "Error: Failed to delete hobby.";
        }
    } else {
        echo "Invalid request parameters";
    }
} else {
    echo "Invalid request method";
}
?>
