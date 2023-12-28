<?php
include "../classes/delete.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    include("../classes/db.php");

    $userId = $_GET['id'];

    $listDeleter = new ListDeleter($con);
    $deletionResult=$listDeleter->deleteList($userId);
    if ($deletionResult) {
        header("location: http://localhost//project1/details/home.php");
    } else {
        echo "Error: Failed to delete list item.";
    }
}
?>
