<?php
    
    include_once('../DataStructure/context.php');
    include_once('../Application/commonFunctions.php');
	include_once('partials/header.php');
     
    session_start();                         

    // function autoLoadAppToGroupPage($className) {
    //     $path = '../Application/';
    //     $extension = '.php';
    //     $fileName = $path . $className . $extension;
    //     if(!file_exists($fileName)) {
    //         return false;    
    //     }    
    //     include_once $fileName;
    // }

    // spl_autoload_register('autoLoadAppToGroupPage');

    $dbh = new DBHandler();
    $pdo = $dbh->connectWithDb();
    $user = $_SESSION["username"]; 
    $currentGroup = $_GET['selectedGroup'];
    echo '<h3>' . $currentGroup . '</h3>';

?>
    <div class="pageBlock">
        <form action="group.php" method="post">  
            <table class="postsTable">
                <tbody>                                                                                                                                                              
                    <?php  
                        foreach (Context::$posts as $groupPost){
                            if ($groupPost->groupName == $currentGroup){
                                ?>
                                <form class="groupPageBlock" method="get">                                                            
                                    <tr>
                                        <td colspan="2"><h1><?php echo $groupPost->content ?></h1></td>
                                    </tr>
                                    <?php
                                        foreach(Context::$comments as $postComment){
                                            if($postComment->postId == $groupPost->postId){
                                                ?>
                                                <tr>
                                                    <td><p><?php echo $postComment->creator . ": " ?></p></td>
                                                    <td><p><?php echo $postComment->content  ?></p></td>
                                                </tr>                                            
                                                <?php
                                            }
                                        }
                                    ?>                                                                                        
                                </form>                                                                                
                                <?php    
                            }
                        }                                                                                                         
                    ?>                    
                </tbody>
            </table>         
        </form>
    </div>                                     
<?php
	
	include_once('partials/footer.php');	

?>
