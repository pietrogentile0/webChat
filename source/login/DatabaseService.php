<?php
class DatabaseService{
    private $host;
    private $user;
    private $password;
    private $database;

    private $connection;

    function __construct($host, $user, $password, $database){
        $this->host;
        $this->user;
        $this->password;
        $this->database;
    }

    public function getConnection(){
        try{
            $this->connection = new mysqli($host, $user, $password, $database);
        } catch (Exception $e){
            throw new Exception($e);
        }

        return $this->connection;
    }
}