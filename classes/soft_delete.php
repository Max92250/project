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
        $stmt = $this->con->executePreparedStatement($sql, 'ss', $userId,$hobby);

        if ($stmt) {
        
            return true;
        } else {
           
            return false;
        }
    }
}