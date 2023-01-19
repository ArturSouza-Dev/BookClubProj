<?php

        function autoLoad($className) {
            $path = '../Application/';
            $extension = '.php';
            $fileName = $path . $className . $extension;
            if(!file_exists($fileName)) {
                return false;    
            }    
            include_once $fileName;
        }

        spl_autoload_register('autoLoad');   
                

    class DBBuilder {                        

        function createTableUsers() {
            $sqlCreateTableUsers = "CREATE TABLE users (
                username varchar(15) PRIMARY KEY,
                password VARCHAR(15) NOT NULL,
                firstName VARCHAR(30) NOT NULL,
                lastName VARCHAR(30) NOT NULL,
                email VARCHAR(30) NOT NULL,
                favGenre VARCHAR(30) NOT NULL                                     
                )";

            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTableUsers);
                echo "Table users created succesfully";
            } catch(PDOException $e) {
                echo "Users table creation falied: " . $e->getMessage();
            }
        }           
        
        function insertUsers() {
            $sqlInsertDataIntoUsers = "INSERT  INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('johnDoe', 'pwd', 'John', 'Doe', 'jd@email.com', 'Fantasy')";
            $sqlInsertDataIntoUsers2 = "INSERT  INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('anakinSkywalker', 'pwd', 'Anakin', 'skywalker', 'as@email.com', 'Fantasy')";            
            $sqlInsertDataIntoUsers3 = "INSERT  INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('ArtSouza', 'pwd', 'Artur', 'Souza', 'arts@email.com', 'Fantasy')";            
            $sqlInsertDataIntoUsers4 = "INSERT  INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('LouisMalCarater', 'pwd', 'Louis', 'Nassau', 'ls@email.com', 'Fantasy')";
            $sqlInsertDataIntoUsers5 = "INSERT  INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('MarieSouza', 'pwd', 'Marie', 'Souza', 'ms@email.com', 'Philosophical Fiction')";            
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoUsers);
                $pdo->exec($sqlInsertDataIntoUsers2); 
                $pdo->exec($sqlInsertDataIntoUsers3);   
                $pdo->exec($sqlInsertDataIntoUsers4);   
                $pdo->exec($sqlInsertDataIntoUsers5);                
                echo "Data insertion to table users succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to users table failed: " . $e->getMessage();
            }
        }

        function createTableBooks() {  
            $sqlCreateTableBooks = "CREATE TABLE books (
                bookId INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
                bookName varchar(30) NOT NULL,
                bookGenre varchar(30),
                bookAuthor VARCHAR(30)                                                         
                )";
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTableBooks);
                echo "Table books created succesfully";
            } catch(PDOException $e) {
                echo "Table books creation falied: " . $e->getMessage();
            }
        }   
        
        function insertBooks() {
            $sqlInsertDataIntoBooks = "INSERT  INTO books (bookName, bookGenre, bookAuthor) VALUES ('The Archer', 'Historical Fiction', 'Bernard Cornwell')";
            $sqlInsertDataIntoBooks2 = "INSERT  INTO books (bookName, bookGenre, bookAuthor) VALUES ('The Ilusionist', 'Philosophical Fiction', 'Paulo Coelho')";
            $sqlInsertDataIntoBooks3 = "INSERT  INTO books (bookName, bookGenre, bookAuthor) VALUES ('Space Run', 'Sci-Fi', 'George Lucas')";
            $sqlInsertDataIntoBooks4 = "INSERT  INTO books (bookName, bookGenre, bookAuthor) VALUES ('Lord Of The Rings', 'Fantasy', 'J. R. R. Tolkien')";
                        
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoBooks);
                $pdo->exec($sqlInsertDataIntoBooks2); 
                $pdo->exec($sqlInsertDataIntoBooks3); 
                $pdo->exec($sqlInsertDataIntoBooks4);                
                echo "Data insertion to table Books succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to Books table failed: " . $e->getMessage();
            }
        }

        function createTableGroups() {  
            $sqlCreateTableGroups = "CREATE TABLE groups (
                groupName varchar(15) PRIMARY KEY,
                groupCreator VARCHAR(15) REFERENCES users(username),   
                maxParticipants INT,   
                groupAdm1 varchar(15),
                groupAdm2 varchar(15),
                groupGenre varchar(30),
                bookId INT REFERENCES books(bookId)                                                                                                                       
                )";
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTableGroups);
                echo "Table groups created succesfully";
            } catch(PDOException $e) {
                echo "Table groups creation falied: " . $e->getMessage();
            }
        }        

        function insertGroups() {
            
            $sqlInsertDataIntoGroups = "INSERT INTO groups (groupName, groupCreator, maxParticipants, groupAdm1, groupAdm2, groupGenre, bookId) VALUES ('FantasyFanatics', 'johnDoe', 10, 'ArtSouza', 'anakinSkywalker', 'Fantasy', 4)";
            $sqlInsertDataIntoGroups2 = "INSERT INTO groups (groupName, groupCreator, maxParticipants, groupAdm1, groupGenre, bookId) VALUES ('Fictionist Wars', 'ArtSouza', 7, 'johnDoe', 'Historical Fiction', 1)";
            $sqlInsertDataIntoGroups3 = "INSERT INTO groups (groupName, groupCreator, maxParticipants, groupGenre, bookId) VALUES ('SciFanatics', 'anakinSkywalker', 10, 'Sci-Fi', 3)";
            $sqlInsertDataIntoGroups4 = "INSERT INTO groups (groupName, groupCreator, maxParticipants, groupGenre, bookId) VALUES ('BeyondThePages', 'MarieSouza', 10, 'Philosophical Fiction', 2)";            
                       
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoGroups);
                $pdo->exec($sqlInsertDataIntoGroups2); 
                $pdo->exec($sqlInsertDataIntoGroups3);  
                $pdo->exec($sqlInsertDataIntoGroups4);                
                echo "Data insertion to table Groups succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to Groups table failed: " . $e->getMessage();
            }
        }

        function createTableUserGroup() {  
            $sqlCreateTableUserGroup = "CREATE TABLE usergroup (
                groupName varchar(15) REFERENCES groups (groupName),
                username varchar(15) REFERENCES users (username),
                iscreator boolean NOT NULL,
                PRIMARY KEY (groupName, username)                                                                                                   
                )";
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTableUserGroup);
                echo "Table groups created succesfully";
            } catch(PDOException $e) {
                echo "Table groups creation falied: " . $e->getMessage();
            }
        }      
        
        function insertUserGroup() {
            $sqlInsertDataIntoUserGroup = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('anakinSkywalker', 'BeyondThePages', false)";
            $sqlInsertDataIntoUserGroup2 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('LouisMalCarater', 'BeyondThePages', false)";
            $sqlInsertDataIntoUserGroup3 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('ArtSouza', 'BeyondThePages', false)";
            $sqlInsertDataIntoUserGroup4 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('MarieSouza', 'BeyondThePages', true)";
            $sqlInsertDataIntoUserGroup5 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('johnDoe', 'FantasyFanatics', true)";
            $sqlInsertDataIntoUserGroup6 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('ArtSouza', 'Fictionist Wars', true)";
            $sqlInsertDataIntoUserGroup7 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('anakinSkywalker', 'SciFanatics', true)";
            $sqlInsertDataIntoUserGroup8 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('ArtSouza', 'FantasyFanatics', false)";
            $sqlInsertDataIntoUserGroup9 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('anakinSkywalker', 'FantasyFanatics', false)";
            $sqlInsertDataIntoUserGroup10 = "INSERT  INTO usergroup (username, groupName, iscreator) VALUES ('johnDoe', 'Fictionist Wars', false)";
            
                 
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoUserGroup); 
                $pdo->exec($sqlInsertDataIntoUserGroup2); 
                $pdo->exec($sqlInsertDataIntoUserGroup3); 
                $pdo->exec($sqlInsertDataIntoUserGroup4); 
                $pdo->exec($sqlInsertDataIntoUserGroup5); 
                $pdo->exec($sqlInsertDataIntoUserGroup6); 
                $pdo->exec($sqlInsertDataIntoUserGroup7); 
                $pdo->exec($sqlInsertDataIntoUserGroup8); 
                $pdo->exec($sqlInsertDataIntoUserGroup9); 
                $pdo->exec($sqlInsertDataIntoUserGroup10);                                               
                echo "Data insertion to table usergroup succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to usergroup table failed: " . $e->getMessage();
            }
        }

        function createTablePosts() {
            $sqlCreateTablePosts = "CREATE TABLE posts (
                postId INT AUTO_INCREMENT PRIMARY KEY,
                groupName varchar(15) REFERENCES groups (groupName),
                creator VARCHAR(15) NOT NULL,
                content VARCHAR(150) NOT NULL,
                postedDate DATE                                                    
                )";

            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTablePosts);
                echo "Table posts created succesfully";
            } catch(PDOException $e) {
                echo "Table posts creation falied: " . $e->getMessage();
            }
        }           
        
        function insertPosts() {
            $sqlInsertDataIntoPosts = "INSERT  INTO posts (groupName, creator, content, postedDate) VALUES ('FantasyFanatics', 'anakinSkywalker', 'The best fantasy book I have ever read!', sysdate())";
                 
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoPosts);                                             
                echo "Data insertion to table posts succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to posts table failed: " . $e->getMessage();
            }
        }

        function createTableComments() {
            $sqlCreateTableComments = "CREATE TABLE comments (
                commentId INT AUTO_INCREMENT PRIMARY KEY,
                postId INT REFERENCES posts (postId),
                creator VARCHAR(15) NOT NULL,
                content VARCHAR(200) NOT NULL,
                postedDate DATE                                                
                )";

            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlCreateTableComments);
                echo "Table comments created succesfully";
            } catch(PDOException $e) {
                echo "Table comments creation falied: " . $e->getMessage();
            }
        }           
        
        function insertComments() {
            $sqlInsertDataIntoComments = "INSERT  INTO comments (postId, creator, content, postedDate) VALUES (1, 'ArtSouza', 'I agree!', sysdate())";
                 
            try {
                $conn = new DBHandler();
                $pdo = $conn->connectWithDb();
                $pdo->exec($sqlInsertDataIntoComments);                                             
                echo "Data insertion to table comments succeeded.<br>";
            } catch(PDOException $e) {
                echo "Data insertion to comments table failed: " . $e->getMessage();
            }
        }



        /*                 WGY NOT WORKING?
        function insertData($query) {           
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $pdo->exec($query);
            $pdo->exec($query);                                            
        }
        */
    }

    
    $dbb = new DBBuilder();

    //$dbb->createTableUsers();
    //$dbb->insertUsers();
    //$dbb->createTableBooks();
    //$dbb->insertBooks();
    //$dbb->createTableGroups();
    //$dbb->insertGroups();
    //$dbb->createTableUserGroup();
    //$dbb->insertUserGroup();
    //$dbb->createTablePosts();
    //$dbb->insertPosts();
    //$dbb->createTableComments();
    //$dbb->insertComments();
    
    
