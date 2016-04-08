<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Writer.php" );


class WriterMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri and a.uri = ?";
        $this->selectAllStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri";        
    } 
    
    function getCollection( array $raw ) {
        
        $writerCollection = array();
        foreach($raw as $row) {
            array_push($writerCollection, $this->doCreateObject($row));
        }
        
        return $writerCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Writer($array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setFullName($array['full_name']);
            $obj->setDescription($array['description']);
            $obj->setDateOfBirth($array['birth_date']);
            $obj->setDateofDeath($array['death_date']);
        } 
        
        return $obj;
    }

    protected function doInsert( \gb\domain\DomainObject $object ) {
        /*$values = array( $object->getName() ); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );*/
    }
    
    function update( \gb\domain\DomainObject $object ) {
        //$values = array( $object->getName(), $object->getId(), $object->getId() ); 
        //$this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
    }
    
    function getWritersByName ($name) {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = 
		b.writer_uri and a.full_name like '$name%'";        
        $writers = $con->executeSelectStatement($selectStmt, array()); 
        print $selectStmt;
        return $this->getCollection($writers);
    }
    
	function getWritersByNameAndDoB ($name, $dob) {
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = 
		b.writer_uri and a.full_name like '$name%' 
		and a.birth_date like '$dob%'";
		$writers = $con->executeSelectStatement($selectStmt, array()); 
		print $selectStmt;
        return $this->getCollection($writers);
	}
	
	function getWritersByNameAndDoBAndCountry ($name, $dob, $country) {
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT a.*, b.* from person a, writer b, has_citizenship c
		where a.uri = b.writer_uri 
		and a.full_name like '$name%'
		and a.birth_date like '$dob%'
		and c.person_uri = a.uri 
		and c.country_iso_code = '$country' "
		;
		$writers = $con->executeSelectStatement($selectStmt, array()); 
		print $selectStmt;
        return $this->getCollection($writers);
	}
	
	function getAllWriters () {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri";        
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }
}	


?>
