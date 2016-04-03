<?php
namespace gb\mapper;

require_once("gb/connection/ConnectionManager.php");

abstract class Mapper {    
    protected static $con;
    
    function __construct() {
                 
        if (!isset(self::$con)) {            
            self::$con = new \gb\connection\ConnectionManager();
        }
    }

    function find( $id ) {
       
        $rows = self::$con->executeSelectStatement($this->selectStmt(), array($id));
        $result = array() ;
        foreach($rows as $row) {
            $result = $row;
        }
        
        $object = $this->createObject( $result );
        return $object; 
    }
    
    function findAll( ) {        
        $customers = self::$con->executeSelectStatement($this->selectAllStmt(), array());
        return $this->getCollection($customers);        
    }

    function createObject( $array ) {
        $obj = $this->doCreateObject( $array );
        return $obj;
    }

    function insert( \gb\domain\DomainObject $obj ) {
        $this->doInsert( $obj );
    }

    function getConnectionManager() {
        return self::$con;
    }
    
    abstract function update( \gb\domain\DomainObject $object );
    protected abstract function getCollection( array $raw );
    protected abstract function doCreateObject( array $array );
    protected abstract function doInsert( \gb\domain\DomainObject $object );
    protected abstract function selectStmt();
    
}

?>
