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