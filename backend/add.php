<?php

include "../classes/form.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include("../classes/db.php");

    $listAdder = new ListAdder($con);

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