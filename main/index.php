<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>List Films</title>
</head>
<body>
    <div class="container-md mt-4 font-size">

        <div class="d-flex justify-content-between align-items-center w-100">
            <h1>Welcome, <?php echo $_GET['username']; ?></h1>
            <div>
                <button id="logout" class="btn btn-danger font-size">Logout</button>
            </div>
        </div>


        <div class="d-flex flex-row w-100 pt-2">
            <div class="me-2 d-flex gap-1">
                <button class="btn btn-primary font-size" id="add_film">Add</button>
                <button id="upload_file" class="btn btn-primary font-size">Upload File</button>
            </div>
            <div class="ms-3">
                <button class="btn btn-secondary rounded-end font-size" id="sort_by_title">Sort by title</button>
            </div>
        </div>

        <div class="px-0 pt-2 pb-4 input-group">
            <input type="search" class="form-control rounded-start rounded-end-0 shadow-none font-size" id="search_film" placeholder="Search" >
            <label>
                <select id="dropdown-search" class="form-select border-start-0 rounded-start-0 shadow-none font-size">
                    <option value="" selected disabled>Search By</option>
                    <option value="character">Character name</option>
                    <option value="film">Name of film</option>
                </select>
            </label>
        </div>

        <?php
            require_once '../db/main.php';
            $sqlMain = new SqlMain();

            $username = $_GET['username'];

            if($username) {
                $films = $sqlMain->getFilms($username);
            }
        ?>
        <table class="table table-bordered table-font">
            <thead>
                <tr>
                    <th>Film Title</th>
                    <th>Realize Year</th>
                    <th>Format</th>
                    <th>Actors</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody id="table_body">
                <?php foreach ($films as $film): ?>
                    <tr class="table-body-row" data-id="<?php echo $film['id']; ?>">
                        <td class="title px-1">
                            <?php echo $film['title']; ?>
                        </td>
                        <td class="release px-1">
                            <?php echo $film['release_year']; ?>
                        </td>
                        <td class="format px-1">
                            <?php echo $film['format']; ?>
                        </td>
                        <td class="actors px-1">
                            <?php echo $film['actors']; ?>
                        </td>
                        <td class="px-1">
                            <div class="d-flex flex-row">
                                <button data-delete-id="<?php echo $film['id']; ?>" class="border rounded-start delete">
                                    <i class='fa fa-trash'></i>
                                </button>
                                <button data-view-id="<?php echo $film['id']; ?>" class="border border-start-0 rounded-end view">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal_add">
        <div class="modal-dialog">
            <div class="modal-content font-size">
                <form id="add_form">
                    <div class="modal-header">
                        <div class="modal-title fs-3">Add Film</div>
                        <button id="close_top" type="button" class="btn btn btn-close font-size" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input name="username" type="hidden" value="<?php echo $_GET['username'];?>">
                        <div class="my-2">
                            <label for="film_title">Film Title</label>
                            <input class="form-control" type="text" name="film_title" id="film_title">
                            <span id="title_error" class="text-danger"></span>
                        </div>
                        <div class="my-2">
                            <label for="release">Realize Year</label>
                            <input class="form-control" type="number" max="<?php echo date('Y'); ?>" min="1900" name="release" id="release">
                            <span id="release_error" class="text-danger"></span>
                        </div>
                        <div class="my-2">
                            <label for="format">Format</label>
                            <select name='format' id="format" class="form-select font-size">
                                <option selected disabled value="">Format</option>
                                <option value="VHS">VHS</option>
                                <option value="DVD">DVD</option>
                                <option value="Blu-Ray">Blu-Ray</option>
                            </select>
                            <span id="format_error" class="text-danger"></span>
                        </div>
                        <div class="my-2">
                            <label for="actors">Actors</label>
                            <textarea class="form-control" name="actors" id="actors"></textarea>
                            <span id="actors_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="close_footer" type="button" class="btn btn-danger font-size" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary font-size">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="modal_confirm" class="modal fade font-size">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="confirm-form">
                    <input name="username" type="hidden" value="<?php echo $_GET['username'];?>">
                    <div class="modal-header">
                        <div class="modal-title fs-3">Delete</div>
                        <button type="button" class="btn btn btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <span class="font-size">Are sure you want delete:
                            <b id="form_film_title"></b>?
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button id="close_confirm_footer" type="button" class="btn btn-danger font-size" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary font-size">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
</body>
</html>