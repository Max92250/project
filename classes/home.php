<?php

class HobbyViewer
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getOrganizedData($searchTerm = null)
    {

        $searchCondition = $searchTerm ? "AND list.details LIKE '%$searchTerm%'" : '';

        $query = "SELECT list.users_id, MAX(list.details) as details, 
            GROUP_CONCAT(category.hobby_id) as hobby_ids, 
            GROUP_CONCAT(category.hobbie) as hobbies
            FROM list
            LEFT JOIN category ON list.users_id = category.user_id AND category.is_deleted='0'
            WHERE 1 AND list.details LIKE ?
            GROUP BY list.users_id
            ORDER BY list.users_id
            ";
            
       $params = ['s', "%$searchTerm%"];

        $stmt = $this->con->executePreparedStatement($query,...$params);
       
        $organizedData = [];

        foreach($stmt as $row) {
            $productID = $row['users_id'];
            $productName = $row['details'];
            $hobbyIds = explode(',', $row['hobby_ids']);
            $hobbies = explode(',', $row['hobbies']);

            $organizedData[$productID] = ['username' => $productName, 'hobbies' => array_combine($hobbyIds, $hobbies)];
        }

        return $organizedData;
    }
}

    


