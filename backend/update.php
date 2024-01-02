<?php

include "../classes/include.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        // Update Hobby
        $newUserId = $_POST['new'];
        $oldHobbie = $_POST['hobbie'];
        $newDetails = $_POST['details'];

        $updateSuccess = $action->performAction('updateHobby', $newUserId, $oldHobbie, $newDetails);

        if ($updateSuccess !== false) {
            header("location: http://localhost/project1/details/home.php");
            exit();
        } else {
            echo "Error: Failed to update hobby.";
        }
    } elseif (isset($_POST['details'])) {
        // Add List
        $details = $_POST['details'];

        $lastInsertId = $action->performAction('addList', $details);

        if ($lastInsertId !== false) {
            header("location: http://localhost/project1/details/home.php?id=$lastInsertId");
            exit();
        } else {
            echo "Error: Failed to insert row.";
        }
    }
}
?>
