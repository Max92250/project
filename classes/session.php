<?php

class CustomSessionHandler
{
    private $user;


    public function __construct()
    {
       
        if ($this->isLoggedIn()) {
           
        } else {
            header("location: index.php"); 
        }

        $this->user = $_SESSION['user'];

    }

    private function isLoggedIn()
    {
        
        return isset($_SESSION['user']) ;
    }

    public function getUser()
    {
        return $this->user;
    }

    
}


$customSessionHandler = new CustomSessionHandler();

