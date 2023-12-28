<?php
class ListAdder
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function addList($details)
    {
        $time = strftime("%X"); 
        $date = strftime("%B %d, %Y"); 
        $query = "INSERT INTO list (details, date_posted, time_posted) 
        VALUES (?, ?, ?)";

        $stmt = $this->con->executePreparedStatement($query, 'sss', $details, $date, $time);

        if ($stmt) 
        {
            $lastInsertId = $stmt->insert_id;

            return $lastInsertId;
        }

        return false;
    }
}