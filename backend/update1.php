<?php

class HobbyUpdater
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function updateHobby($newUserId, $oldHobbie, $newDetails)
    {
        $query = "UPDATE category SET hobbie=? WHERE hobbie=? AND user_id=?";

        $stmt = $this->con->executePreparedStatement($query, 'sss', $newDetails, $oldHobbie, $newUserId);

        if ($stmt) {
            $lastInsertId = $stmt->insert_id;

    return $lastInsertId;
        } else {
            return false;
        }
    }
}

if (isset($_POST['submit'])) {
    include "db.php";

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