<?php

class Database{

    private static $instance = null;
    private $connexion;

    private function __construct(){
        $host = 'localhost';
        $db = 'province_part';
        $user = 'root';
        $password = '';

        try{
            $this -> connexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
            ]);
        }catch(PDOException $e){
            try{
                header("Location: /errors/db.html");
                exit();
            }catch(Throwable $t){
                echo 'problem with header';
                exit();
            }
            
            exit;
        }
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnexion(){
        return $this -> connexion;
    }
}
