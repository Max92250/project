<?php
include "db.php";

class HobbyUpdater
{
    private $con;
    private $hobbie;
    private $ni;
    private $row;

    public function __construct($con)
    {
        $this->con = $con;
        $this->initializeData();
    }

    private function initializeData()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->hobbie = $_GET['hobby'];
            $this->ni = $_GET['ni'];
            $this->fetchHobbyDetails();
        }
    }

    private function fetchHobbyDetails()
    {
        $query = "SELECT * FROM category WHERE hobbie = ?";
        $stmt = $this->con->executePreparedStatement($query, 's', $this->hobbie);

        $this->row = $this->con->fetch_assoc($stmt);
      
    }

    public function renderForm()
    {
        include '../details/update.php';
    }
}


$hobbyUpdater = new HobbyUpdater($con);
$hobbyUpdater->renderForm();

?>