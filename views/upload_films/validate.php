<?php

require_once "../../db/main.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$sqlWork = new SqlMain();

if($_SERVER['REQUEST_METHOD'] === 'POST'){


    $request = file_get_contents('php://input');
    $request = json_decode($request, true);

    $errors = [];

    if($request['username'] === ''){
        $errors[] = ['code' => 1, 'message' => 'You cannot fill username path!'];
    }
    if($request['username'] !== '' && !$sqlWork->usernameCheck($request['username'])){
        $errors[] = ['code' => 2, 'message' => 'Wrong username!'];
    }

    if ($request['filename'] === '') {
        $errors[] = ['code' => 3, 'message' => 'You must choose a file to upload!'];
    }

    if($request['filename'] !== '') {
        $maxFileSize = 10*1024*1024;
        if($request['filesize'] !== '' && $request['filesize'] > $maxFileSize) {
            $errors[] = ['code' => 4, 'message' => 'File size is too big!'];
        }

        if($request['fileContent'] === ''){
            $errors[] = ['code' => 5, 'message' => 'File do not have content!'];
        }
    }
    $result = [];
    if($request['fileContent'] !== ''){
        $text = $request['fileContent'];
        $entries = preg_split('/\n\s*\n/', $text);

        foreach ($entries as $entry) {
            $lines = preg_split('/\n/', $entry);
            $movies = [];
            foreach ($lines as $line){
                $exploded_line = explode(': ', $line, 2);
                if (count($exploded_line) == 2) {
                    $key = $exploded_line[0];
                    $value = $exploded_line[1];
                    $movies[$key] = $value;
                } else {
                    $errors[] = ['code' => 6, 'message' => 'Content it`s not valid!'];
                }
            }
            $result[] = $movies;
        }


        if(empty($result)){
            $errors[] = ['code' => 6, 'message' => 'Content it`s not valid!'];
        }
        else{
            $countStr = "";
            foreach ($result as $res){
                foreach ($res as $key => $value){
                    $countStr .= "{$key}: {$value}";
                }
                $countStr .= "\n\n\n";
            }
            $res1 = preg_replace("/\n\s*\n/", '', $request['fileContent']);
            $res1 = preg_replace("/\n/", '', $res1);

            $res2 = preg_replace("/\n\s*\n/", '', $countStr);
            $res2 = preg_replace("/\n/", '', $res2);

            if(strlen($res1) !== strlen($res2)){
                $errors[] = ['code' => 6, 'message' => 'Content it`s not valid!'];
            }
        }
    }


    if(!empty($errors)){
        echo json_encode(['status' => false, 'errors' => $errors]);
        die();
    }
    else{
        if($sqlWork->appendMovies($request['username'], $result)){
            echo json_encode(['status' => true, 'redirect' => "http://localhost:63342/filmsTask/main/index.php?username={$request['username']}"]);
            die();
        }
    }
}
