<?php

    class DBHandler {

        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "BookClubDB";
        private $connection;        

        
        function __construct() {
            //$this->connection = $this->connectWithDb();
        }       
        
        
        public function connectWithoutDb() {
            $dsn = "mysql:host=" . $this->host;
            $pdo = new PDO($dsn, $this->username, $this->password);
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                   
                echo "Connection succeeded.<br>";                                                        
                $sql = "CREATE DATABASE BookClubDB";   
                $pdo->exec($sql);            
                echo "Database created successfully<br>";                
                return $pdo;        
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . "<br>";        
            }                                     
        } 
              

        public function connectWithDb() {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database;
            $pdo = new PDO($dsn, $this->username, $this->password);
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                                                        
                return $pdo;               
            } catch(PDOException $e) {
                echo "Connection with DB failed: " . $e->getMessage();        
            }                        
        }                
        
    }

    