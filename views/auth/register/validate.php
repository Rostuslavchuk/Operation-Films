<?php
require_once '../../../db/main.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$sqlWork = new SqlMain();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $request = file_get_contents('php://input');
    $request = json_decode($request, true);

    $errors = [];
    if(empty($request['username_register'])){
        $errors[] = ['status' => false, 'code' => 1, 'message' => 'You cannot fill username path!'];
    }
    if($sqlWork->usernameCheck($request['username_register'])){
        $errors[] = ['status' => false, 'code' => 2, 'message' => "User: {$request['username_register']} was exists!"];
    }
    if(empty($request['first_name'])){
        $errors[] = ['status' => false, 'code' => 3, 'message' => 'You cannot fill firstname path!'];
    }
    if(empty($request['second_name'])){
        $errors[] = ['status' => false, 'code' => 4, 'message' => 'You cannot fill secondname path!'];
    }

    if(isset($request['age'])){
        if(!is_numeric($request['age'])){
            $errors[] = ['status' => false, 'code' => 5, 'message' => 'Age is not a number!'];
        }
        else if(abs((int)$request['age']) < 16){
            $errors[] = ['status' => false, 'code' => 6, 'message' => 'You must have over 16 years!'];
        }
    }
    if(empty($request['age'])){
        $errors[] = ['status' => false, 'code' => 7, 'message' => 'You cannot fill age path!'];
    }

    if(empty($request['password_register'])){
        $errors[] = ['status' => false, 'code' => 8, 'message' => 'You cannot fill password path!'];
    }
    if(empty($request['re_password_register'])){
        $errors[] = ['status' => false, 'code' => 9, 'message' => 'You cannot fill re-password path!'];
    }
    if($request['password_register'] !== '' && $request['re_password_register'] !== ''){
        if($request['password_register'] !== $request['re_password_register']){
            $errors[] = ['status' => false, 'code' => 10, 'message' => 'Passwords are not equal!'];
        }
    }


    if (!empty($errors)) {
        echo json_encode(['status' => false, 'errors' => $errors]);
        die();
    }
    else{
        if($sqlWork->addUser($request)){
            echo json_encode(['status' => true, 'redirect' => 'http://localhost:63342/filmsTask/views/auth/login/login.php']);
            die();
        }
    }
}