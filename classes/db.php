<?php

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $db;
    private $pdo;

    public function __construct($servername, $username, $password, $db) {
        try {
            $this->pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function executePreparedStatement($sql, $types, ...$params) {
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            return $this->pdo->errorInfo();
        }

        if (!empty($types)) {
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key + 1, $value, $this->getType($types[$key]));
            }
        } else {
            foreach ($params as $key => &$value) {
                $stmt->bindValue($key + 1, $value);
            }
        }

        $result = $stmt->execute();

        if (!$result) {
            return $stmt->errorInfo();
        }

        return $stmt;
    }

    private function getType($types) {
        switch ($types) {
            case 's':
                return PDO::PARAM_STR;
            case 'i':
                return PDO::PARAM_INT;
            default:
                return PDO::PARAM_STR;
        }
    }

    public function checkIfRowsExist($stmt) {
        return $stmt->rowCount() > 0;
    }

    public function fetch_assoc($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetch_id() {
        return $this->pdo->lastInsertId();
    }

    public function closeConnection() {
        $this->pdo = null;
    }
}

$con = new DatabaseConnection("localhost", "root", "", "ping");

$pdo = $con->getPdo();



?>
