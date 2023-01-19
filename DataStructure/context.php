<?php

    include_once ('user.class.php');
    include_once ('group.class.php');
    include_once ('post.class.php');
    include_once ('comment.class.php');
    include_once ('book.class.php');
    include_once ('../Application/DBHandler.php');

    class Context
    {

        static $users = [];
        static $posts = [];
        static $comments = [];
        static $groups = [];
        static $books = [];     

        public static function loadContext(){
            
            Context::$users = Context::loadUsers();          
            Context::$posts = Context::loadPosts();
            Context::$comments = Context::loadComments();
            Context::$groups = Context::loadGroups();
            Context::$books = Context::loadBooks();

        }

        public static function loadUsers(){
           
            try{
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();                
                $stmt = $pdo->prepare("SELECT * FROM users");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                while($row = $stmt->fetch()){
                    array_push(Context::$users, $row);                  
                }                         
            } 
            catch(PDOException $e){
                echo "Failed to load users context: " . $e->getMessage();
            }
                
            return Context::$users;

        }

        public static function loadPosts(){

            try{
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();                  
                $stmt = $pdo->prepare("SELECT * FROM posts");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
                while($row = $stmt->fetch()){
                    array_push(Context::$posts, $row);                  
                }              
            } 
            catch(PDOException $e){
                echo "Failed to load posts context: " . $e->getMessage();
            }
            
            return Context::$posts;

        }

        public static function loadComments(){

            try{
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();                   
                $stmt = $pdo->query("SELECT * FROM comments");
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Comment');
                while ($row = $stmt->fetch()){
                    array_push(Context::$comments, $row);
                }             
            } 
            catch(PDOException $e){
                echo "Failed to load comments context: " . $e->getMessage();
            }

            return Context::$comments;

        }

        public static function loadGroups(){

            try{
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();                  
                $stmt = $pdo->query("SELECT * FROM groups");                
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Group');
                while ($row = $stmt->fetch()){                    
                    $stmt2 = $pdo->prepare("SELECT username FROM usergroup WHERE groupName = '$row->groupName'");
                    $stmt2->execute();                                                           
                    while ($row2 = $stmt2->fetchColumn(0)){                        
                        array_push($row->participants, $row2);
                    }  
                    array_push(Context::$groups, $row);
                }              
            } 
            catch(PDOException $e){
                echo "Failed to load groups context: " . $e->getMessage();
            }
            
            return Context::$groups;

        }

        public static function loadBooks(){

            try{
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();                   
                $stmt = $pdo->query("SELECT * FROM books");
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');
                while ($row = $stmt->fetch()){
                    array_push(Context::$books, $row);
                }
            return Context::$books;             
            } 
            catch(PDOException $e){
                echo "Failed to load books context: " . $e->getMessage();
            }

        }        

    }