<?php
    session_start();
    session_destroy();
    header("location: http://localhost/project1/details/index.php");
    exit();
?>