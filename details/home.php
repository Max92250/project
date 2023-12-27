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

// Usage example:

include "../backend/db.php";

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
    <link rel="stylesheet" type="text/css" href="../styles/home.css" />
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