<?php

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $db;
    private $con;

    public function __construct($servername, $username, $password, $db) {
        $this->con = new mysqli($servername, $username, $password, $db);

        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }
    }


    public function executePreparedStatement($sql, $types, ...$params) {
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            die("Error in prepared statement: " . $this->con->error);
        }
     
        $stmt->bind_param($types, ...$params);

        $result = $stmt->execute();

        if (!$result) {
            die("Error executing statement: " . $stmt->error);
        }

        return $stmt;
    }
    
    public function closeConnection() {
        
        $this->con->close();
    }
}

$con = new DatabaseConnection("localhost", "root", "", "ping");
return $con;

?>
