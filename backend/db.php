<?php

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $db;
    private $con;

    public function __construct($servername, $username, $password, $db) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;

        $this->connect();
    }

    private function connect() {
        $this->con = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection() {
        return $this->con;
    }

    public function closeConnection() {
        mysqli_close($this->con);
    }
}

// Usage example
$database = new DatabaseConnection("localhost", "root", "", "ping");
$con = $database->getConnection();

?>
