<?php
namespace gb\connection;

class ConnectionManager {
    protected static $PDO; 
    
    function __construct() {
 
        if ( ! isset(self::$PDO) ) { 
            include('configuration.php');
            self::$PDO = new \PDO( $config["dsn"], $config["username"], $config["password"] );
            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }
    
    protected function prepareSQLStatement ($selectString) {
        return self::$PDO->prepare($selectString);
    }
           
    function executeSelectStatement ($selectString, $paras) {
        $stmt = $this->prepareSQLStatement ($selectString);
        $stmt->execute ($paras);        
        return $stmt->fetchAll ( \PDO::FETCH_ASSOC );
    }
    
    function executeUpdateStatement ($updateString, $paras) {
        $stmt = $this->prepareSQLStatement ($updateString);
        $stmt->execute($paras);
        return $stmt->rowCount();
    }
}
?>