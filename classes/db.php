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
             return $this->con->connect_error;
        }
    }
    public function getMysqli() {
        return $this->con;
    }

    public function executePreparedStatement($sql, $types, ...$params) {
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            return $this->con->error;
        }
     
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
     

        $result = $stmt->execute();

        if (!$result) {
            return  $stmt->error;
        }
        $result = $stmt->get_result();
        
    if ($result === false) {
        return ['status' => 'error', 'message' => 'Failed to get result.'];
    }


        return $result;
    }
   

    public function checkIfRowsExist($result) {
      
        return mysqli_num_rows($result) > 0;
    }

    public function fetch_assoc($result) {
      
        return  $result->fetch_assoc();;
    }
    public function fetch_id($result) {
      
        return  $result->insert_id;
    }
    
    public function closeConnection() {
        
        return $this->con->close();
    }
}

$con = new DatabaseConnection("localhost", "root", "", "ping");

$mysqli = $con->getMysqli();

?>
