<?php include "../backend/user.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../styles/user.css" />
</head>
<body>

                <?php
        
          if ($Data) {
              echo "<table>";
              echo "<tr>";
              echo "<th>ID</th>";
              echo "<th>Username</th>";
              echo "<th>Password</th>";
              echo "</tr>";
  
              foreach ($Data as $Id => $data) {
                  echo "<tr>";
                  echo "<td>{$Id}</td>";
                  echo "<td>{$data['username']}</td>";
                  echo "<td>{$data['password']}</td>";
                  echo "</tr>";
              }
  
              echo "</table>";
          } else {
              echo "No data to display.";
          }
      
            ?>

                
    
</body>
</html>