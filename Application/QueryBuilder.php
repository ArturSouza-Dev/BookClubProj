<?php 

    function autoLoadApplicationToQueryBuilder($className) {
        $path = '../Application/';
        $extension = '.php';
        $fileName = $path . $className . $extension;         
        if(!file_exists($fileName)) {
            return false;    
        }                                                                                               
        include_once $fileName;
    }

    spl_autoload_register('autoLoadApplicationToQueryBuilder');
    
    function autoLoadDataStructureToQueryBuilder($className) {
        $path = '../DataStructure/';
        $extension = '.class.php';
        $fileName = $path . $className . $extension;         
        if(!file_exists($fileName)) {
            return false;    
        }                                                                                               
        include_once $fileName;
    }

    spl_autoload_register('autoLoadDataStructureToQueryBuilder');    

    class QueryBuilder {             

        /*
        function showUserGroups($userName, $pdo){  
                    
            $index = 0;
            $groups = array();
            $sql = "SELECT groupName FROM groups WHERE (groupCreator = '$userName' OR groupAdm1 = '$userName' OR groupAdm2 = '$userName' OR participant1 = '$userName' OR participant2 = '$userName' OR participant3 = '$userName' OR participant4 = '$userName' OR participant5 = '$userName'";
            $statement = $pdo->prepare($sql);
            $statement->execute();  
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $groups[$index] = $row;
                $index++; 
            }                        
            return $groups;                             
        }
    */ 

        static function bindQueryParameters($query, $paramValuesArray) {            
            call_user_func_array(array ($query, 'bind_param'), $paramValuesArray);
        }
    
        // For parameterless queries
        static function runParameterlessQuery($query) {
            $dbh = new DBHandler();
            $stmt = $dbh->connectWithDB()->prepare($query);
            $stmt->execute();
             while($result = $stmt->fetchAll()) {
              return $result;
             }
          }

        // For parametrised queries
        function runParametrisedQuery ($query, $param_value_array) {
            $dbh = new DBHandler();
            $stmt = $dbh->connectWithDB()->prepare($query);
            $this->bindQueryParameters($query, $param_value_array);
            $stmt->execute();      
            $result = $stmt->fetch();
            return $result;
        }        

        // input, update, delete
        function voidQuery ($query, $param_value_array) : void {
            $dbh = new DBHandler();
            $stmt = $dbh->connectWithDB()->prepare($query);        
            $this->bindQueryParameters($query, $param_value_array);
            $stmt->execute();
        }                            

    }
    