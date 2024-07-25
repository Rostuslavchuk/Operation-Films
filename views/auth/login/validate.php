<?php
require_once "../../../db/main.php";

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Origin: POST");
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$sqlWork = new SqlMain();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $request = file_get_contents('php://input');
    $request = json_decode($request, true);

    $errors = [];

    if(empty($request['username_login'])){
        $errors[] = ['code' => 1, 'message' => 'You cannot fill username path!'];
    }
    if(empty($request['password_login'])){
        $errors[] = ['code' => 2, 'message' => 'You cannot fill password path!'];
    }

    if($request['username_login'] !== '' && !$sqlWork->usernameCheck($request['username_login'])){
        $errors[] = ['code' => 3, 'message' => 'Wrong username!'];
    }
    if($request['password_login'] !== '' && !$sqlWork->loginPasswordCheck($request['password_login'], $request['username_login'])){
        $errors[] = ['code' => 4, 'message' => 'Wrong password!'];
    }

    if(!empty($errors)){
        echo json_encode(['status' => false, 'errors' => $errors]);
        die();
    }
    else{
        if(isset($request['remember_me'])){
            setcookie('username', $request['username_login'], time()+60*60*7, '/');
            setcookie('hashed_password', base64_encode($request['password_login']), time()+60*60*7, '/');

            session_start();
            $_SESSION['username'] = $request['username_login'];
            session_regenerate_id();
            session_commit();
        }


        if($res = $sqlWork->createTableForFilms($request['username_login'])){
            echo json_encode(['status' => true, 'redirect' => "http://localhost:63342/filmsTask/main/index.php?username={$request['username_login']}"]);
            die();
        }
    }
}
