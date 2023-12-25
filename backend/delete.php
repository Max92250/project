<?php

class ListDeleter
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function deleteList($userId)
    {
        $stmt = mysqli_prepare($this->con, "DELETE FROM list WHERE users_id = ?");
        
        if (!$stmt) {
        
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $userId);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            return true;
        } else {
          
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    include("db.php");

    $userId = $_GET['id'];

    $listDeleter = new ListDeleter($con);
    $deletionResult=$listDeleter->deleteList($userId);
    if ($deletionResult) {
        header("location: http://localhost//project1/details/home.php");
    } else {
        echo "Error: Failed to delete list item.";
    }
}
?>
