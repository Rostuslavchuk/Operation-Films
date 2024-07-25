<?php


class SqlMain
{
    private $server = '127.0.0.1';
    private $username = 'root';
    private $password = '';

    private $connection;

    public function __construct()
    {
        $this->connection = $this->connectDb();
    }

    private function connectDb()
    {
        $connection = new mysqli($this->server, $this->username, $this->password);

        if($connection->connect_error){
            http_response_code(500);
            die('Connection error: ' . $connection->connect_error);
        }

        $database = "CREATE DATABASE IF NOT EXISTS users";
        if($connection->query($database) !== TRUE){
            http_response_code(500);
            die('Create database error: ' . $connection->error);
        }

        mysqli_select_db($connection, 'users');

        $tableUserData = "CREATE TABLE IF NOT EXISTS user_data (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            first_name VARCHAR(255) NOT NULL,
            second_name VARCHAR(255) NOT NULL,
            age INT(11) UNSIGNED NOT NULL, 
            password VARCHAR(255) NOT NULL,
            UNIQUE KEY (username),
            PRIMARY KEY (id)
        )ENGINE=InnoDB DEFAULT charset=utf8 collate=utf8_general_ci";

        if($connection->query($tableUserData) !== TRUE){
            http_response_code(500);
            die('Create tableUserData error: ' . $connection->error);
        }
        return $connection;
    }

    public function addUser($user){

        $addUser = $this->connection->prepare('INSERT INTO user_data 
        (`username`, `first_name`, `second_name`, `age`, `password`) 
        VALUES (?, ?, ?, ?, ?)');

        $username = $user['username_register'];
        $firstName = $user['first_name'];
        $secondName = $user['second_name'];
        $age = (int)$user['age'];
        $password = password_hash($user['password_register'], PASSWORD_DEFAULT);

        $addUser->bind_param('sssis', $username, $firstName, $secondName, $age, $password);

        if(!$addUser->execute()){
            http_response_code(500);
            die('Check addUser error!');
        }
        else{
            $addUser->close();
            return true;
        }
    }

    public function usernameCheck($username){
        $checkUsername = $this->connection->prepare('SELECT * FROM user_data where username = ?');
        $checkUsername->bind_param('s', $username);

        if(!$checkUsername->execute()){
            http_response_code(500);
            die('Check username error!');
        }
        $result = $checkUsername->get_result();
        $count = $result->num_rows;
        $checkUsername->close();
        return $count > 0;
    }

    public function loginPasswordCheck($password, $username){
        $checkPassword = $this->connection->prepare('SELECT * FROM user_data where username = ?');
        $checkPassword->bind_param('s', $username);

        if(!$checkPassword->execute()){
            http_response_code(500);
            die('Check password error!');
        }
        $result = $checkPassword->get_result();
        if($result->num_rows > 0){
            $isEqual = false;
            while($data = $result->fetch_assoc()){
                $isEqual = password_verify($password, $data['password']);
            }
            $checkPassword->close();
            return $isEqual;
        }
    }


    public function createTableForFilms($username){
        $tableFilms = "CREATE TABLE IF NOT EXISTS $username (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user_films VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            release_year INT NOT NULL,
            format VARCHAR(255) NOT NULL,
            actors TEXT NOT NULL,
            INDEX user_films_index (user_films),
            FOREIGN KEY (user_films) REFERENCES user_data(username)
        )ENGINE=InnoDB DEFAULT charset=utf8 collate=utf8_general_ci";

        if($this->connection->query($tableFilms) !== TRUE){
            http_response_code(500);
            die('Create films_data error: ' . $this->connection->error);
        }
        else{
            return true;
        }
    }

    public function appendMovies($username, $movies)
    {
        $insert = $this->connection->prepare("INSERT INTO $username 
        (`user_films`, `title`, `release_year`, `format`, `actors`) VALUES (?, ?, ?, ?, ?)");

        foreach ($movies as $movie){
            $title = $movie['Title'];
            $year = $movie['Release Year'];
            $format = $movie['Format'];
            $stars = $movie['Stars'];

            $insert->bind_param('sssss', $username, $title, $year, $format, $stars);

            if(!$insert->execute()){
                http_response_code(500);
                die('Insert films_data error: ' . $this->connection->error);
            }
        }
        $insert->close();
        return true;
    }

    public function getFilms($username){
        $selectAll = $this->connection->prepare("SELECT * FROM $username");

        if(!$selectAll->execute()){
            http_response_code(500);
            die('Error while get all values!');
        }

        $res = $selectAll->get_result();

        $res_array = [];

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $res_array[] = $row;
            }
        }

        return $res_array;
    }

    public function addFilm($request){
        $username = $request['username'];
        $add = $this->connection->prepare("INSERT INTO $username
            (`user_films`, `title`, `release_year`, `format`, `actors`) VALUES (?, ?, ?, ?, ?)");

        $user_films = $request['username'];
        $title = $request['film_title'];
        $release = $request['release'];
        $format = $request['format'];
        $actors = $request['actors'];

        $add->bind_param('sssss', $user_films, $title, $release, $format, $actors);

        if(!$add->execute()){
            http_response_code(500);
            die('Error during add film!');
        }
        else{
            $add->close();
            $getLast = $this->connection->prepare("SELECT * FROM {$request['username']} ORDER BY id DESC limit 1");
            if(!$getLast->execute()){
                http_response_code(500);
                die('Error during getting last!');
            }
            else{
                $result = $getLast->get_result();
                if($result->num_rows > 0){
                    while($dataGet = $result->fetch_assoc()){
                        $getLast->close();
                        return $dataGet;
                    }
                }
            }
        }
    }

    public function removeFilm($request)
    {
        $delete = $this->connection->prepare("DELETE FROM {$request['username']} where id = ?");
        $id = (int)$request['id'];
        $delete->bind_param('i', $id);

        if(!$delete->execute()){
            http_response_code(500);
            return false;
        }
        else{
            $delete->close();
            return true;}
    }
}




