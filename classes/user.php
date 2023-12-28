<?php
class MyGuestsFetcher
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function fetchMyGuestsData()
    {
        $query = "SELECT * FROM MYGuests";
        $stmt = $this->con->executePreparedStatement($query,'');
        $Data = [];

        foreach($stmt as $row) {
            $Id = $row['id'];
            $Firstname = $row['firstname'];
            $Password = $row['password'];

            $Data[$Id] = ['username' => $Firstname, 'password' => $Password];
        }

        return $Data;
       
    }
}