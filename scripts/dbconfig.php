<?php

class BakeryDBClient {
    
    # connection details
    private $db = 'db_ba_php_app';
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pwd = '';
    protected $con;

    # initialize database connection
    public function getConnection(){
        try{
            return $this->con = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $user, $pwd);
        }catch(PDOException $ex){
            print_r($ex);
        }
    }

    # destroy database connection
    public function clsConnection(){
        $this->con = null;
    }

    # login the user
    public function userLogin($user, $pwd){
        try{
            $con = $this->getConnection();
            $query = 'CALL sp_loginUser(?,?)';
            $stmt = $con->prepare($query);
            $stmt->bindParams(1, $user);
            $stmt->bindParams(2, $pwd);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        }catch(PDOException $ex){
            print_r($ex);
        }
    }
}