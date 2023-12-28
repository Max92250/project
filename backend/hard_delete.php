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
        
        $stmt = $this->con->executePreparedStatement($sql, 'ss', $userId,$hobbyId);
        if ($stmt){
                return true;
            
        } else {
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
