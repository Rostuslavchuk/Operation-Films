<?php


require_once '../db/main.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$sqlMain = new SqlMain();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $request = file_get_contents('php://input');
    $request = json_decode($request, true);

    if($request['action'] === 'add'){
        $errors = [];

        if(empty($request['film_title'])){
            $errors[] = ['code' => 1, 'message' => 'You don`t fill title of film!'];
        }
        if(empty($request['release'])){
            $errors[] = ['code' => 2, 'message' => 'You don`t fill realize year!'];
        }
        if(!is_numeric($request['release'])){
            $errors[] = ['code' => 3, 'message' => 'Don`t valid realize year!'];
        }
        if(empty($request['format'])){
            $errors[] = ['code' => 4, 'message' => 'You don`t chose format!'];
        }

        $actors = htmlspecialchars($request['actors']);
        if(empty($actors)){
            $errors[] = ['code' => 5, 'message' => 'You don`t write actors!'];
        }
        if(preg_match("/[0-9]/", $actors)){
            $errors[] = ['code' => 6, 'message' => 'I`ts not valid actors names'];
        }

        if(!empty($errors)){
            echo json_encode(['status' => false, 'errors' => $errors]);
            die();
        }
        else{
            if($res = $sqlMain->addFilm($request)){
                echo json_encode(['film' => $res]);
                die();
            }
        }
    }

    if($request['action'] === 'delete'){
        if($res = $sqlMain->removeFilm($request)){
            echo json_encode(['deleted' => true]);
        }
    }
}