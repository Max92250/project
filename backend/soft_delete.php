<?php

class HobbyDeleter
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function deleteHobby($userId, $hobby)
    {
        $sql = "UPDATE category SET is_deleted = 1 WHERE user_id = ? AND hobbie = ?";
        
        $stmt = mysqli_prepare($this->con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $userId, $hobby);
            $success = mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            return true;
        } else {
            echo "Error: " . mysqli_error($this->con);
            return false;
        }
    }
}

include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET["ni"];
    $hobby = $_GET["hobby"];

    $hobbyDeleter = new HobbyDeleter($con);
    $deletionSuccess = $hobbyDeleter->deleteHobby($userId, $hobby);

    if ($deletionSuccess) {
        header("location: http://localhost/project1/details/home.php");
        exit();
    } else {
 
        echo "Error: Failed to delete hobby.";
    }
}
?>
