<?php

class Action
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function performAction($action, ...$params)
    {
        switch ($action) {
            case 'addList':
                return $this->addList(...$params);
            case 'updateHobby':
                return $this->updateHobby(...$params);
            
            default:
                return ['status' => 'error', 'message' => 'Invalid action.'];
        }
    }

    private function addList($details)
    {
        $time = strftime("%X"); 
        $date = strftime("%B %d, %Y"); 
        $query = "INSERT INTO list (details, date_posted, time_posted) 
        VALUES (?, ?, ?)";

        $stmt = $this->con->executePreparedStatement($query, 'sss', $details, $date, $time);

     
        if ($stmt) 
        {
            return $this->con->fetch_id($stmt);
        }

        return false;
    }

    private function updateHobby($newUserId, $oldHobby, $newDetails)
    {
        $query = "UPDATE category SET hobbie=? WHERE hobbie=? AND user_id=?";

        $stmt = $this->con->executePreparedStatement($query, 'sss', $newDetails, $oldHobby, $newUserId);

        
        if ($stmt) {
            return $this->con->fetch_id($stmt);
           
        } else {
            return false;
        }
    }
}

?>
