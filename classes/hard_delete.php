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