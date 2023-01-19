<?php

    include_once('../DataStructure/context.php');
    include_once('../Application/commonFunctions.php');
	include_once('partials/header.php');

    Context::loadGroups();
    Context::loadBooks();
    
    session_start();    
      
    if(isset($_SESSION["username"])){
        echo '<h3>Welcome ' . $_SESSION["username"] . '</h3>';                
    } else{
        header("location:./logout.php");
    }         
    
	if(isset($_POST['logoff'])){
		session_destroy();
		header('location:login.php');
	}
    /*
    function autoLoadAppToHomePage($className) {
        $path = '../Application/';
        $extension = '.php';
        $fileName = $path . $className . $extension;
        if(!file_exists($fileName)) {
            return false;    
        }    
        include_once $fileName;
    }
    
    spl_autoload_register('autoLoadAppToHomePage');
    */
    $dbh = new DBHandler();
    $pdo = $dbh->connectWithDb();
    $userName = $_SESSION["username"]; 

?>

<div class="pageBlock">                                                                                              
    <?php    
        foreach(Context::$groups as $myGroups){
            if(($myGroups->groupCreator == $userName || $myGroups->groupAdm1 == $userName || $myGroups->groupAdm2 == $userName) || in_array($userName, $myGroups->participants)){
                ?>
                <form class="homePageBlock" method="GET"> 
                    <ul>                           
                        <li ><h1><?php echo $myGroups->groupName ?></h1></li>
                        <?php
                        foreach(Context::$books as $currentBook){
                            if($currentBook->bookId == $myGroups->bookId){
                                ?><li><h2><?php echo "Currently reading: ".$currentBook->bookName ?></h2></li><?php
                            }
                        }
                        ?>                            
                        <!--<input type="submit" name="redirectToGroupPage" value="Access">-->
                        </a>
                        <li><?php echo "=======================================================" ?></li>     
                    </ul>
                </form>                                                                                
                <?php    
            }
        }
    /*
        $sql = "SELECT groupName, bookName FROM groups, books WHERE groups.currentBookId = books.bookId";
        $statement = $pdo->prepare($sql);
        $statement->execute();                 
        foreach($statement as $row){
            $sql = "SELECT groupName FROM groups WHERE groupCreator = '$userName' OR groupAdm1 = '$userName' OR groupAdm2 = '$userName' OR participant1 = '$userName' OR participant2 = '$userName' OR participant3 = '$userName' OR participant4 = '$userName' OR participant5 = '$userName'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(); 
            foreach($stmt as $row2) {
                if ($row["groupName"] == $row2["groupName"]) {
                    ?>
                    <form method="GET"> 
                        <ul>
                        <a href="group.php?groupName=<?php echo $row["groupName"] ?> ">
                            <li ><h1><?php echo "Group: " .$row["groupName"] ?></h1></li>
                            <li><h2><?php echo "Currently reading: ".$row["bookName"] ?></h2></li>
                            <!--<input type="submit" name="redirectToGroupPage" value="Access">-->
                            </a>
                            <li><?php echo "=======================================================" ?></li>     
                        </ul>
                    </form>                                                                                
                    <?php                            
                }
            }
        } 
        */                    
    ?>        
</div>                                     
                
<?php
	
	include_once('partials/footer.php');	

?>
