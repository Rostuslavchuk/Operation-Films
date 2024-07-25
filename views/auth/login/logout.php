
<?php
    session_start();
    session_unset();

    setcookie('username', '', time() - 3600, '/');
    setcookie('hashed_password', '', time() - 3600, '/');

    session_destroy();
    header("Location: login.php");
?>