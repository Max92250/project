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
