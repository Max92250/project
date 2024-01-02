<?php
include "../classes/include.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  

    $userId = $_GET['id'];

  
    $deletionResult=$actionHandler->performAction('deleteList', $userId);
    if ($deletionResult) {
        header("location: http://localhost//project1/details/home.php");
    } else {
        echo "Error: Failed to delete list item.";
    }
}
?>
