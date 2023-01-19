<?php
    
    include_once('../Application/commonFunctions.php');
	include_once('partials/header.php');	 
    session_start();  
    
    if(isset($_SESSION["currentGroup"])){
        echo '<h3>' . $_SESSION["currentGroup"] . '</h3>';        
    } else{
        header("location:./logout.php");
    }        

    function autoLoadAppToGroupPage($className) {
        $path = '../Application/';
        $extension = '.php';
        $fileName = $path . $className . $extension;
        if(!file_exists($fileName)) {
            return false;    
        }    
        include_once $fileName;
    }

    spl_autoload_register('autoLoadAppToGroupPage');

    $dbh = new DBHandler();
    $pdo = $dbh->connectWithDb();
    $user = $_SESSION["username"]; 
    $currentGroup = $_SESSION["currentGroup"];

?>

<div class="pageBlockMenu">
<button name="newPost">Create post</button>
</div>
<div class="pageBlock">
    <form method="post">  
        <table class="postsTable">
            <tbody>                                                                                                                                                              
                <?php                                                 
                    $sql = "SELECT content FROM posts, groups WHERE groups.groupName = '$currentGroup'";
                    $statement = $pdo->prepare($sql);
                    $statement->execute();                 
                    foreach($statement as $row){                                                                
                        ?>
                        <tr>
                            <td colspan="2"><h1><?php echo $row["content"] ?></h1></td>
                        </tr>
                        <?php 
                            $sql = "SELECT cm.creator, cm.content FROM comments cm, posts WHERE cm.postId = posts.postId";
                            $statement2 = $pdo->prepare($sql);
                            $statement2->execute();                                     
                            foreach($statement2 as $row){                                    
                            ?>
                            <tr>
                                <td width="50"><p><?php echo $row["creator"] . ":" ?></p></td>
                                <td width="200"><p><?php echo $row["content"] ?></p></td>
                            </tr>
                            <?php
                            }
                        ?>                                                                                                   
                        <td colspan="2"><?php echo "=======================================================" ?></td>                                                                                     
                        <?php                        
                    }                                                                                
                ?>
            </tbody>
        </table>         
    </form>
</div>                                     

<?php
	
	include_once('partials/footer.php');	

?>
