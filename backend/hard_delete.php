<?php

class HobbyDeleter
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function deleteHobby($userId, $hobbyId)
    {
        $sql = "DELETE FROM category WHERE user_id = ? AND hobby_id = ?";
        
        $stmt = mysqli_prepare($this->con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $userId, $hobbyId);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                return true;
            } else {
                echo "Error: " . mysqli_error($this->con);
                return false;
            }
        }else{
            return false;
        }
    }
}

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET["ni"];
    $hobbyId = $_GET["hobby_id"];

    $hobbyDeleter = new HobbyDeleter($con);
    $deletionResult=$hobbyDeleter->deleteHobby($userId, $hobbyId);
    if ($deletionResult) {
        header("location: http://localhost/project1/details/home.php");
    } else {
        
        echo "Error: Failed to delete hobby.";
    }

} else {
    echo "Invalid request method";
}
?>
