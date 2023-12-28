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
        $categorySql = "DELETE FROM category WHERE user_id = ?";
        $categoryStmt = $this->con->executePreparedStatement($categorySql, 'i', $userId);

        $listSql = "DELETE FROM list WHERE users_id = ?";
        $listStmt = $this->con->executePreparedStatement($listSql, 'i', $userId);

        if ($categoryStmt && $listStmt) {
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
