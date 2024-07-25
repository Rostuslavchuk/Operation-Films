<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="clean-switch-master/clean-switch.css">
    <link rel="stylesheet" href="../style.css">
    <title>Login</title>
</head>
<body>

    <div id="modal_login" class="modal font-size">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_login">
                    <div class="modal-header d-flex justify-content-between">
                        <div class="modal-title fs-3">Login</div>
                        <a class="text-decoration-none" href='http://localhost:63342/filmsTask/views/auth/register/register.php'>Register</a>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2" >
                            <label for="username_login">Username</label>
                            <input value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : '' ?>" id="username_login" type="text" name="username_login" class="form-control font-size" autofocus>
                            <span id="username_login_error" class="text text-danger font-size"></span>
                        </div>
                        <div class="mb-2" >
                            <label for="password_login">Password</label>
                            <input value="<?php echo isset($_COOKIE['hashed_password']) ? base64_decode($_COOKIE['hashed_password']) : '' ?>" id="password_login" type="password" name="password_login" class="form-control font-size">
                            <span id="password_login_error" class="text text-danger font-size"></span>
                        </div>
                        <div class="mt-3" >
                            <label class="cl-switch cl-switch-large cl-switch-white d-flex flex-row align-items-center">
                                <input id="remember_me" name="remember_me" data-toggle="toggle" type="checkbox" class="font-size">
                                <span class="switcher"></span>
                                <label for="remember_me" class="ps-2">Remember me</label>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit_login" id="submit_login" class="btn btn-primary font-size" >Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="option.js" defer></script>

</body>
</html>