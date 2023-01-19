<?php    

    include_once ('../DataStructure/user.class.php');
    include_once ('../DataStructure/group.class.php');
    include_once ('../DataStructure/post.class.php');
    include_once ('../DataStructure/comment.class.php');
    include_once ('../DataStructure/book.class.php');
    include_once('../DataStructure/context.php');

    // GROUP FUNCTIONS

    function addGroupToDb($groupName, $groupCreator, $maxParticipants, $groupAdm1 = null, $groupAdm2 = null, $groupGenre = null, $bookId = null){
        $sqlStart = "INSERT INTO groups (groupName, groupCreator, maxParticipants";
        $sqlEnd = "VALUES ('$groupName', '$groupCreator', '$maxParticipants'";

        if (!is_null($groupAdm1)){
            $sqlStart += ", groupAdm1";
            $sqlEnd += ", '$groupAdm1'";
        }
        if (!is_null($groupAdm2)){
            $sqlStart += ", groupAdm2";
            $sqlEnd += ", '$groupAdm2'";
        }
        if (!is_null($groupGenre)){
            $sqlStart += ", groupGenre";
            $sqlEnd += ", '$groupGenre'";
        }
        if (!is_null($bookId)){
            $sqlStart += ", bookId";
            $sqlEnd += ", '$bookId'";
        }

        $sql = $sqlStart + ") " + $sqlEnd + ")";

        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();                
            $pdo->exec($sql);                
            echo "Group '" . $groupName . "' created succesfully!";
        } catch(PDOException $e) {
            echo "Group addition to database falied: " . $e->getMessage();
        }        
    }            

    function addGroupParticipant($gName, $newMember){
        foreach(Context::$groups as $gp){
            if ($gp->groupName = $gName){
                if (count($gp->participants) < ($gp->maxParticipants -1)){
                    array_push($gp->participants, $newMember);
                } else {
                    echo "The group is full.";
                } 
            }
        }                  
    }

    function getGroupParticipant($gName, $userName){
        foreach(Context::$groups as $gp){
            if ($gp->groupName = $gName){
                foreach($gp->participants as $participant){
                    if ($userName == $participant){
                        return $participant;
                    }
                }
            }
        }
    }

    function deleteGroupParticipant($gName, $userName){
        foreach(Context::$groups as $gp){
            if ($gp->groupName = $gName){
                if(in_array($userName, $gp->participants)){
                    unset($gp->participants['userName']);
                    $gp->participants = array_values($gp->participants);
                }
            }
        }
    }
    

    function setGroupAdmin($gName, $newAdmin, $replacedAdminUsername = null){

        foreach(Context::$groups as $gp){
            if ($gp->groupName = $gName){
                if (is_null($gp->groupAdm1) || is_null($gp->groupAdm1)) {
                    if (is_null($gp->groupAdm1)){
                        $gp->groupAdm1 = $newAdmin;
                        $gp->deleteGroupParticipant($newAdmin);
                    } else {
                        $gp->groupAdm2 = $newAdmin;
                        $gp->deleteGroupParticipant($newAdmin);
                    }
                } else {
                    if ($replacedAdminUsername == $gp->groupAdm1){
                        $gp->groupAdm1 = $newAdmin;
                        $gp->deleteGroupParticipant($newAdmin);
                    } else if ($replacedAdminUsername == $gp->groupAdm2){
                        $gp->groupAdm2 = $newAdmin;
                        $gp->deleteGroupParticipant($newAdmin);
                    } else {
                        echo "There is no admin username = " . $replacedAdminUsername;  
                    }
                }            
            }
        }                         
    }                   

    // USER FUNCTIONS 
   
    function addUserToDb($username, $firstName, $lastName, $password, $email, $favGenre = null){
        $sqlStart = "INSERT INTO users (username, password, firstName, lastName, email";
        $sqlEnd = "VALUES ('$username', '$password', '$firstName', '$lastName', '$email'";

        if (!is_null($favGenre)){
            $sqlStart += ", favGenre";
            $sqlEnd += ", '$favGenre'";
        }            
    
        $sql = $sqlStart + ") " + $sqlEnd + ")";

        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();                
            $pdo->exec($sql);                
            echo "User '" . $username . "' created succesfully!";
        } catch(PDOException $e) {
            echo "User addition to database falied: " . $e->getMessage();
        }        
    }                    

    // BOOK FUNCTIONS

    function addBookToDb($bookName, $bookGenre = null, $bookAuthor = null){
        $sqlStart = "INSERT INTO books (bookName";
        $sqlEnd = "VALUES ('$bookName'";

        if (!is_null($bookGenre)){
            $sqlStart += ", bookGenre";
            $sqlEnd += ", '$bookGenre'";
        }
        if (!is_null($bookAuthor)){
            $sqlStart += ", bookAuthor";
            $sqlEnd += ", '$bookAuthor'";
        }

        $sql = $sqlStart + ") " + $sqlEnd + ")";

        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $pdo->exec($sql);                
        } catch(PDOException $e) {
            echo "Book addition to database falied: " . $e->getMessage();
        }
    }

    function getBookId(){
        $sql = "SELECT MAX(bookId) FROM books";
        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $idOutput = ($pdo->exec($sql)) + 1;                
        } catch(PDOException $e) {
            echo "Operation (getBookId) failed " . $e->getMessage();
        }
        return $idOutput;
    }

    // POST FUNCTIONS

    function addPostToDb($creator, $content, $postedDate){
        $sql = "INSERT INTO posts (creator, content, postedDate) VALUES ('$creator', '$content', '$postedDate')";
        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $pdo->exec($sql);                
        } catch(PDOException $e) {
            echo "Post creation falied: " . $e->getMessage();
        }
    }

    function getPostId(){
        $sql = "SELECT MAX(postId) FROM posts";
        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $idOutput = ($pdo->exec($sql)) + 1;                
        } catch(PDOException $e) {
            echo "Operation (getPostId) failed: " . $e->getMessage();
        }
        return $idOutput;
    }

    function addComment($aPost, $comment){
        if (count($aPost->postComments) == $aPost->maxComments){
            $aPost->maxComments = $aPost->maxComments * 2;
        }
        array_push($aPost->postComments, $comment);
    }

    // COMMENTS FUNCTIONS

    function addCommentToDb($postId, $creator, $content, $postedDate){
        $sql = "INSERT INTO comments (postId, creator, content, postedDate) VALUES ('$postId', '$creator', '$content', '$postedDate')";
        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $pdo->exec($sql);                
        } catch(PDOException $e) {
            echo "Comment creation falied: " . $e->getMessage();
        }
    }

    function getCommentId(){
        $sql = "SELECT MAX(commentId) FROM comments";
        try {
            $conn = new DBHandler();
            $pdo = $conn->connectWithDb();
            $idOutput = ($pdo->exec($sql)) + 1;                
        } catch(PDOException $e) {
            echo "Operation (getCommentId) failed: " . $e->getMessage();
        }
        return $idOutput;
    }

?>