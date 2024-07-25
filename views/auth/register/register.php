<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Register</title>
</head>
<body>

<div id="modal_register" class="modal font-size">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_register">
                <div class="modal-header d-flex justify-content-between">
                    <div class="modal-title fs-3">Register</div>
                    <a class="text-decoration-none" href='http://localhost:63342/filmsTask/views/auth/login/login.php'>Login</a>
                </div>
                <div class="modal-body">
                    <div class="mb-2" >
                        <label for="username">Username</label>
                        <input id="username_register" type="text" name="username_register" class="form-control font-size" autofocus>
                        <span id="username_reg_error" class='text text-danger font-size'></span>
                    </div>
                    <div class="mb-2" >
                        <label for="firstname">FirstName</label>
                        <input id="firstname" type="text" name="first_name" class="form-control font-size">
                        <span id="reg_firstname_error" class='text text-danger font-size'></span>
                    </div>
                    <div class="mb-2" >
                        <label for="secondname">SecondName</label>
                        <input id="secondname" type="text" name="second_name" class="form-control font-size" >
                        <span id="reg_secondname_error" class='text text-danger font-size'></span>
                    </div>
                    <div class="mb-2" >
                        <label for="age">Age</label>
                        <input id="age" type="number" name="age" class="form-control font-size" min="0">
                        <span id="reg_age_error" class='text text-danger font-size'></span>
                    </div>
                    <div class="mb-2" >
                        <label for="password-register">Password</label>
                        <input id="password-register" type="password" name="password_register" class="form-control font-size">
                        <span id="reg_password_error" class='text text-danger font-size'></span>
                    </div>
                    <div class="mb-2" >
                        <label for="re-password-register">Re-Password</label>
                        <input id="re-password-register" type="password" name="re_password_register" class="form-control font-size" >
                        <span id="reg_repassword_error" class='text text-danger font-size'></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit_register" id="submit_register" class="btn btn-primary font-size" >Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="option.js" defer></script>
</body>
</html>

