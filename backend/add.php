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

        $stmt = mysqli_prepare($this->con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sss', $details, $date, $time);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                $lastInsertId = mysqli_insert_id($this->con);
                mysqli_stmt_close($stmt);
                return $lastInsertId;
            }
            return false;
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
