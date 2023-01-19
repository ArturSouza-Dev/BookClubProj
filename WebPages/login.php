
<?php
    include_once('partials/initHeader.php');
    //ob_start();    
    session_start();
    
    $message;    
    
    function autoLoadAppToLoginPage($className) {
        $path = '../Application/';
        $extension = '.php';
        $fileName = $path . $className . $extension;
        if(!file_exists($fileName)) {
            return false;    
        }    
        include_once $fileName;
    }

    spl_autoload_register('autoLoadAppToLoginPage');     
    
    $count = 0;
    $queryBuilder = new QueryBuilder();
    $conn = new DBHandler();
    $pdo = $conn->connectWithDb();

    
?>

<div class="pageBlock">
    <form method="post">   
        <ul>  
            <li>          
                <input type="text" name="username" placeholder="username">
            </li>
            <li>
                <input type="password" name="password" placeholder="password">
            </li>            
            <li>
                <input type="submit" name="login" value="Login">
                <input type="submit" name="redirect" value="Register">
            </li>
        </ul>
    </form>   
    <?php
        if (isset($_POST['login'])) {        

            if(empty($_POST["username"]) || empty($_POST["password"])){
                //$message = '<label>All fields are required!</label>';
                echo "All fields are required!";
            } else{      
                $username = $_POST["username"];
                $password = $_POST["password"];      
                $query = "SELECT * FROM users WHERE username = '$username' and password = '$password'"; 
                $statement = $pdo->prepare($query);
                $statement->execute();
                
                $count = $statement->rowCount();                      
                if ($count > 0){                
                    $_SESSION["username"] = $_POST["username"];
                    header("location:home.php");                
                } else{
                    $message = '<label>Invalid credentials</label>';
                }
            }   
                    
        } elseif (isset($_POST["redirect"])){        
           
            header("location:registration.php");
        }    
        /*        
        if(isset($message)){
            echo $message;
        }
        */
    ?>
</div>                         
        
<?php	

    include_once('partials/footer.php');	
    //ob_end_flush();

?>
