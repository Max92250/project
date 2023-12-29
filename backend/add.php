<?php

include "../classes/include.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    


    $details = $_POST['details'];


    $lastInsertId = $listAdder->addList($details);

    if ($lastInsertId !== false) {
    

        header("location: http://localhost/project1/details/home.php?id=$lastInsertId");
        exit();
    } else {
 
        echo "Error: Failed to insert row";
    }
} 

?>