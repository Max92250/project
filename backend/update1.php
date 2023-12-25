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

        $stmt = mysqli_prepare($this->con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $newDetails, $oldHobbie, $newUserId);
            $success = mysqli_stmt_execute($stmt);

          if($success){
            return true;
          } else {
            echo "Error: " . mysqli_error($this->con);
            return false;
        }

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

    if ($updateSuccess) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    }
}