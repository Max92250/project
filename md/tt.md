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

<?php


class HobbyViewer
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getOrganizedData($startFrom, $perPageRecord, $searchTerm = null)
    {
        $searchCondition = $searchTerm ? "AND list.details LIKE '%$searchTerm%'" : '';

        $query = "SELECT list.users_id,
        MAX(list.details) as details, 
        GROUP_CONCAT(category.hobby_id) as hobby_ids, 
        GROUP_CONCAT(category.hobbie) as hobbies
        FROM list
        LEFT JOIN category ON list.users_id = category.user_id AND category.is_deleted='0'
        WHERE 1 AND list.details LIKE ?
        GROUP BY list.users_id
        ORDER BY list.users_id
        LIMIT ?, ?";

$params = ['sss', "%$searchTerm%", $startFrom, $perPageRecord];
$stmt = $this->con->executeStatement($query, ...$params);
      
        $organizedData = [];
         
        $row =  $this->con->fetch_row($stmt);

        while ($row) {
            $productID = $row['users_id'];
            $productName = $row['details'];
            $hobbyIds = explode(',', $row['hobby_ids']);
            $hobbies = explode(',', $row['hobbies']);

            $organizedData[$productID] = ['username' => $productName, 'hobbies' => array_combine($hobbyIds, $hobbies)];
        }

        return $organizedData;
    }
    
}

<?php

class HobbyViewer
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getOrganizedData($startFrom, $perPageRecord, $searchTerm = null)
    {
        $searchCondition = $searchTerm ? "AND list.details LIKE '%$searchTerm%'" : '';

        $query = "SELECT list.users_id, MAX(list.details) as details, 
            GROUP_CONCAT(category.hobby_id) as hobby_ids, 
            GROUP_CONCAT(category.hobbie) as hobbies
            FROM list
            LEFT JOIN category ON list.users_id = category.user_id AND category.is_deleted='0'
            WHERE 1 $searchCondition
            GROUP BY list.users_id
            ORDER BY list.users_id
            LIMIT $startFrom, $perPageRecord";

        $stmt = $this->con->getMysqli()->prepare($query);
        if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        $organizedData = [];

        while ($row = $result->fetch_assoc()) {
            $productID = $row['users_id'];
            $productName = $row['details'];
            $hobbyIds = explode(',', $row['hobby_ids']);
            $hobbies = explode(',', $row['hobbies']);

            $organizedData[$productID] = ['username' => $productName, 'hobbies' => array_combine($hobbyIds, $hobbies)];
        }

        return $organizedData;
    }
    }
}



include "../backend/db.php";
 include '../backend/session.php';
$hobbyViewer = new HobbyViewer($con);

$perPageRecord = 4;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$startFrom = ($page - 1) * $perPageRecord;

$searchTerm = !empty($_GET['search']) ? $_GET['search'] : null;
$organizedData = $hobbyViewer->getOrganizedData($startFrom, $perPageRecord, $searchTerm);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../styles/homes.css" />
</head>


<body>
    
    <?php
include "nav.php";

?>
    <div class="section">
        <div class="section1">
        <?php
include "form.php";

?>
        </div>
        
        <div class="table">
            <table id='customers' class="main-table" border='1'>
                <tr>
                    <th>ID</th>
                    <th>User name</th>
                    <th>Hobby</th>
                    <th>Update</th>
                    <th>Soft delete</th>
                    <th>Hard delete</th>
                    <th>Delete</th>
                </tr>
                <?php
            foreach ($organizedData as $id => $data) {
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$data['username']}</td>";
                echo "<td>";
                echo "<table class='nested-table'>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                   
                    echo "<tr><td>{$hobby}</tr></td>";
                }
            
                echo "</table>";
                echo "</td>";
                echo "<td colspan='1'>";
                echo "<table id='customer'>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                    $editLink = 'update.php?hobby=' . $hobby . '&ni=' . $id;
                    echo "<tr><td><a class='op' href='$editLink'>edit</a></td></tr>";
                }
                echo "</table>";
                echo "</td>";
                echo "<td>";
                echo "<table>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                    $softDeleteLink = '../backend/soft_delete.php?hobby=' . $hobby . '&ni=' . $id;

                    echo "<tr><td><a class='op' href='$softDeleteLink'>soft delete</a></td></tr>";
                }
                echo "</table>";
                echo "</td>";
                echo "<td>";
                echo "<table>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                    $hardDeleteLink = '../backend/hard_delete.php?hobby_id=' . $hobby . '&ni=' . $id;

                    echo "<tr >
                    <td><a class='op' href='$hardDeleteLink' >hard delete</a></td>
                    </tr>";
                }
                echo "</table>";
                echo "</td>";
                echo '<td><a class="op" href="#" onclick="myFunction(' . $id . ')">delete</a></td>';
                echo "</tr>";
            }
            ?>
            </table>
            <div class="pagination-container">
    <div class="pagination">
                <?php
$query = "SELECT COUNT( DISTINCT list.users_id) FROM list";
$stmt = $con->getMysqli()->prepare($query);
if ($stmt) {
$stmt->execute();
$result = $stmt->get_result();
    
              
            $row = mysqli_fetch_row($result);
                $total_records = $row[0];

                $total_pages = ceil($total_records / $perPageRecord);

                if ($page >= 2) {
                    echo "<a href='home.php?page=" . ($page - 1) . "'> Prev </a>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<a class='active' href='home.php?page=" . $i . "'>" . $i . " </a>";
                    } else {
                        echo "<a href='home.php?page=" . $i . "'>" . $i . " </a>";
                    }
                }

                if ($page < $total_pages) {
                    echo "<a href='home.php?page=" . ($page + 1) . "'> Next </a>";
                }
}
                ?>
            </div>
            </div>
        </div>
    </div>
    <script>
    function myFunction(id) {
        var r = confirm("Are you sure you want to delete this record?");
        if (r == true) {
            window.location.assign("../backend/delete.php?id=" + id);
        }
    }
    </script>
</body>

</html>
<?php

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $db;
    private $con;

    public function __construct($servername, $username, $password, $db) {
        try {
            $this->con = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return $this->errorResponse($e->getMessage());
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
     
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();

        if (!$result) {
            return  $stmt->error;
        }
       
        
    if ($result === false) {
        return ['status' => 'error', 'message' => 'Failed to get result.'];
    }


      
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   

    public function checkIfRowsExist($stmt) {
        return $stmt->rowCount() > 0;
    }
    public function fetch_assoc($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function fetch_id() {
        return $this->con->lastInsertId();
    }
    public function closeConnection() {
        
        return $this->con=null;
    }
}

$con = new DatabaseConnection("localhost", "root", "", "ping");

$mysqli = $con->getMysqli();

?>
<?php


include "../classes/include.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET["ni"];
    $hobbyId = $_GET["hobby_id"];

    $deletionResult = $actionHandler->performAction('HardDeleteHobby', $userId, $hobbyId);
    if ($deletionResult) {
        header("location: http://localhost/project1/details/home.php");
    } else {
        
        echo "Error: Failed to delete hobby.";
    }

} else {
    echo "Invalid request method";
}
?>
