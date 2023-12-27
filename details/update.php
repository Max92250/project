<?php
// update.php

include "../backend/db.php";

class HobbyUpdater
{
    private $con;
    private $hobbie;
    private $ni;
    private $row;

    public function __construct($con)
    {
        $this->con = $con;
        $this->initializeData();
    }

    private function initializeData()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->hobbie = $_GET['hobby'];
            $this->ni = $_GET['ni'];
            $this->fetchHobbyDetails();
        }
    }

    private function fetchHobbyDetails()
    {
        $query = "SELECT * FROM category WHERE hobbie = ?";
        $stmt = $this->con->executePreparedStatement($query, 's', $this->hobbie);

        $result = $stmt->get_result();

        if ($result) {
            $this->row = $result->fetch_assoc();
        } else {
            die("Error fetching hobby details: " . $stmt->error);
        }
    }

    public function renderForm()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Hobby Form</title>
            
            <link rel="stylesheet" type="text/css" href="../styles/update.css" />
        </head>
        
        <body>
            <form class="form" method="POST" action="../backend/update1.php">
                <div class="title">Welcome</div>
                <div class="subtitle">Let's Edit Your Hobby</div>
                <input type="hidden" name="new" value="<?php echo $this->ni; ?>" />
                <input type="hidden" name="hobbie" value="<?php echo $this->hobbie; ?>" />
                <br>
                <input type="text" class="input" name="details" value="<?php echo $this->row['hobbie']; ?>" />
                <p><input name="submit" class="submit" type="submit" value="Update" /></p>
            </form>
        </body>
        
        </html>
        <?php
    }
}

// Example usage
$hobbyUpdater = new HobbyUpdater($con);
$hobbyUpdater->renderForm();
?>
