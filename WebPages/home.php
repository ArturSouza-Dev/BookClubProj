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
                <form class="homePageBlock" method="get"> 
                    <ul>                           
                        <li ><h1><a href="group.php?selectedGroup=<?php echo $myGroups->groupName ?>"><?php echo $myGroups->groupName ?></a></h1></li>
                        <?php
                            foreach(Context::$books as $currentBook){
                                if($currentBook->bookId == $myGroups->bookId){
                                    ?><li><h2><?php echo "Currently reading: ".$currentBook->bookName ?></h2></li><?php
                                }
                            }
                        ?>                                                    
                        <li><?php echo "=======================================================" ?></li>     
                    </ul>
                </form>                                                                                
                <?php    
            }
        }         
    ?>        
</div>                                     
                
<?php
	
	include_once('partials/footer.php');	

?>
