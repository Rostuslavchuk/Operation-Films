<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>View</title>
</head>
<body>
    <div class="container mt-5 font-size">
        <h2 class="text-center" >Film Card</h2>
        <div class="card p-2">
            <div class="my-2 d-flex align-items-center" >
                <b class="mb-0 me-2 font-size">Film Title:</b> <div><?php echo $_GET['title']; ?></div>
            </div>
            <div class="my-2 d-flex align-items-center" >
                <b class="mb-0 me-2 font-size">Film Release:</b> <div><?php echo $_GET['release']; ?></div>
            </div>
            <div class="my-2 d-flex align-items-center" >
                <b class="mb-0 me-2 font-size">Format:</b> <div><?php echo $_GET['format']; ?></div>
            </div>
            <div class="my-2 d-flex align-items-center" >
                <b class="mb-0 me-2 font-size">Actors:</b> <div><?php echo $_GET['actors']; ?></div>
            </div>
            <div class="text-end">
                <a href="#" onclick="history.back()" class="btn btn-secondary font-size">Back</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>