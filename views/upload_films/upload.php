<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <title>Upload films</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

    <div id="modal_upload" class="modal font-size">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_upload" enctype="multipart/form-data">
                    <div class="modal-header d-flex justify-content-between">
                        <div class="modal-title fs-3">Upload films</div>
                        <a class="text-decoration-none" href='http://localhost:63342/filmsTask/views/auth/login/logout.php'>Logout</a>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2" >
                            <label for="username_upload">Username</label>
                            <input id="username_upload" type="text" name="username_upload" class="form-control font-size" autofocus>
                            <span id="username_upload_error" class="text text-danger font-size"></span>
                        </div>
                        <div class="mb-2 d-flex flex-column" >
                            <label for="upload_file">File</label>
                            <a class="text-decoration-none" href="http://localhost:63342/filmsTask/views/upload_films/fileExampleDownload.php">Click here to download example file</a>
                            <input id="upload_file" type="file" name="upload_file" class="form-control font-size" accept=".txt">
                            <span id="file_upload_error" class="text text-danger font-size"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a onclick="history.back()" class="btn btn-secondary font-size" href='#'>Back</a>
                        <button type="submit" name="submit_upload" id="submit_upload" class="btn btn-primary font-size" >Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./upload.js" defer></script>
</body>
</html>