<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div  class="pong">
<a href="logout.php"><i class="fa fa-sign-out" style="font-size:30px;color:red"></i>
</a>
</div>
<form   class="ki"  action="../backend/add.php" method="POST">
            <div class="pp" > ADD LIST </div>
        <div class=" pp form-group row">
   
    
      <input type="text" name="details"  class="col-sm-8" value="">
</div>
<p id="lastInsertedId"></p>
    
    <input type="submit" class=" btn btn-primary " value="add list">


        </form>
        <script>
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Get the ID parameter from the URL
        var itemId = getParameterByName('id');

        // Set the value of the hidden input field
        document.getElementById('lastInsertedId').innerHTML =  itemId ;
    </script>
    
</body>
</html>