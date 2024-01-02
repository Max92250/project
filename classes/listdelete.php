<?php

class ActionHandler
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function performAction($action, ...$params)
    {
        switch ($action) {
            case 'deleteHobby':
                return $this->deleteHobby(...$params);
            case 'hardDeleteHobby':
                return $this->hardDeleteHobby(...$params);
            case 'deleteList':
                return $this->deleteList(...$params);
         
            default:
                return ['status' => 'error', 'message' => 'Invalid action.'];
        }
    }

    private function deleteHobby($userId, $hobby)
    {
        $sql = "UPDATE category SET is_deleted = 1 WHERE user_id = ? AND hobbie = ?";
        $stmt = $this->con->executePreparedStatement($sql, 'ss', $userId, $hobby);

        if ($stmt) {
            return ['status' => 'success', 'message' => 'Hobby deleted successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete hobby.'];
        }
    }

    private function hardDeleteHobby($userId, $hobbyId)
    {
        $sql = "DELETE FROM category WHERE user_id = ? AND hobby_id = ?";
        $stmt = $this->con->executePreparedStatement($sql, 'ss', $userId, $hobbyId);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    private function deleteList($userId)
    {
        $categorySql = "DELETE FROM category WHERE user_id = ?";
        $listSql = "DELETE FROM list WHERE users_id = ?";

        $categoryStmt = $this->con->executePreparedStatement($categorySql, 'i', $userId);
        $listStmt = $this->con->executePreparedStatement($listSql, 'i', $userId);

        if ($categoryStmt && $listStmt) {
            return ['status' => 'success', 'message' => 'List deleted successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete list.'];
        }
    }
}

