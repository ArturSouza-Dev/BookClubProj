<?php
    //ob_start();
    session_start();
	include_once('partials/initHeader.php');
    $message = "";
    
    function autoLoadAppToRegistrationPage($className) {
        $path = '../Application/';
        $extension = '.php';
        $fileName = $path . $className . $extension;
        if(!file_exists($fileName)) {
            return false;    
        }    
        include_once $fileName;
    }

    spl_autoload_register('autoLoadAppToRegistrationPage');

    $queryBuilder = new QueryBuilder();
    $conn = new DBHandler();
    $pdo = $conn->connectWithDb();
    $count = 0;
    
    if (isset($_POST["register"])) {        

        if(empty($_POST["username"]) || empty($_POST['password']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'] || empty($_POST['favgenre']))){
            $message = '<label>All fields are required.</label>';
        } else{      
            $username = $_POST["username"];
            $password = $_POST["password"];  
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];  
            $favgenre = $_POST["favgenre"];  
            $query = "INSERT INTO users (username, password, firstName, lastName, email, favGenre) VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$favgenre')"; 
            
            $statement = $pdo->prepare($query);
            $statement->execute();   
            $count = $statement->rowCount();   
            
            if ($count > 0){                
                $_SESSION["username"] = $_POST["username"];
                header("location:home.php");                
            } else{
                $message = '<label>Something went wrong, please try again.</label>';
            }                                                    
        }                       
    } elseif (isset($_POST["redirect"])){               
        header("location:login.php");
    }    

?>
    
<div class="pageBlock">
    <form method="post">                                                         
        <ul> 
            <li>                
                <input class="post-subtitle" type="text" placeholder="First Name" name="firstname"><br>
            </li>
            <li>                
                <input class="post-subtitle" type="text" placeholder="Last Name" name="lastname"><br>
            </li>                                                
            <li>                
                <input class="post-subtitle" type="text" placeholder="Enter Username" name="username"><br>
            </li>
            <li>                
                <input class="post-subtitle" type="text" placeholder="Enter Email" name="email"><br>
            </li>
            <li>                
                <input class="post-subtitle" type="text" placeholder="Enter youfavorite genre" name="favgenre"><br>
            </li>
            <li>                
                <input class="post-subtitle" type="password" placeholder="Enter Password" name="password"><br>
            </li>             
            <li>
                <input type="submit" name="register" value="Register">
                <input type="submit" name="redirect" value="Return">
            </li>
        </ul> 
        <?php
                if(isset($message)){
                    echo '<label class="text-danger">'.$message.'</label>';
                }
            ?>                                             
    </form>             
</div>

<?php
        	
	include_once('partials/footer.php');	
    
?>
