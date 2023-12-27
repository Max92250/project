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

if ($stmt) {
    $lastInsertId = $stmt->insert_id;

    return $lastInsertId;
}

return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include("../backend/db.php");

    $listAdder = new ListAdder($con);

    $details = $_POST['details'];


    $lastInsertId = $listAdder->addList($details);

    if ($lastInsertId !== false) {
    

        header("location: http://localhost/project1/details/home.php?id=$lastInsertId");
        exit();
    } else {
 
        echo "Error: Failed to insert row";
    }
} 

?>