<?php include "../backend/home.php";?>
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
                    $editLink = '../classes/update.php?hobby=' . $hobby . '&ni=' . $id;
                    echo "<tr><td><a class='op' href='$editLink'>edit</a></td></tr>";
                }
                echo "</table>";
                echo "</td>";
                echo "<td>";
                echo "<table>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                    $softDeleteLink = '../backend/listdelete.php?hobby=' . $hobby . '&ni=' . $id;

                    echo "<tr><td><a class='op' href='$softDeleteLink'>soft delete</a></td></tr>";
                }
                echo "</table>";
                echo "</td>";
                echo "<td>";
                echo "<table>";
                foreach ($data['hobbies'] as $hobbyId => $hobby) {
                    $hardDeleteLink = '../backend/listdelete.php?hobby_id=' . $hobbyId . '&ni=' . $id;

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
            </div>
        </div>
    </div>
    <script>
    function myFunction(id) {
        var r = confirm("Are you sure you want to delete this record?");
        if (r == true) {
            window.location.assign("../backend/listdelete.php?id=" + id);
        }
    }
    

  

    </script>
</body>

</html>