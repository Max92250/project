<?php include '../backend/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" type="text/css" href="styles/home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="styles/home.css" />
    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-light fixed-top justify-content-between" style="background-color: #e3f2fd;">

        <div class="lin">

            <p>Welcome to the Home Page, <?php echo htmlspecialchars($customSessionHandler->getUser()); ?>!
            </p>

        </div>


        <form class=" form-group" action="home.php" method="GET">
            <div class="input-group mb-3">
                <input class="form-control mr-sm-2" type="text" name="search" required
                    value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control"
                    placeholder="Search data">
                <button type="submit" class="btn btn-primary my-2 my-sm-0">Search</button>
            </div>

        </form>


    </nav>


</body>

</html>