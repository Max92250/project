<?php
include "../classes/hubbyupdate.php";

if (isset($_POST['submit'])) {
    include "../classes/db.php";

    $newUserId = $_POST['new'];
    $oldHobbie = $_POST['hobbie'];
    $newDetails = $_POST['details'];

    $hobbyUpdater = new HobbyUpdater($con);
    $updateSuccess = $hobbyUpdater->updateHobby($newUserId, $oldHobbie, $newDetails);

    if ($updateSuccess !== false) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    }
}