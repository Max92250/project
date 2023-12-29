<?php

include "../classes/include.php";
if (isset($_POST['submit'])) {


    $newUserId = $_POST['new'];
    $oldHobbie = $_POST['hobbie'];
    $newDetails = $_POST['details'];

    
    $updateSuccess = $hobbyUpdater->updateHobby($newUserId, $oldHobbie, $newDetails);

    if ($updateSuccess !== false) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    }
}