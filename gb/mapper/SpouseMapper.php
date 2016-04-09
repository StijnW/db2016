<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Spouse.php" );


class SpouseMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri and a.uri = ?";
        $this->selectAllStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri";		
    } 
    
    function getCollection( array $raw ) {
        
        $spouseCollection = array();
        foreach($raw as $row) {
            array_push($spouseCollection, $this->doCreateObject($row));
        }
        
        return $spouseCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Spouse( $array['full_name_writer'] );

            $obj->setFullName($array['full_name_writer']);
			$obj->setSpouse($array['full_name_spouse']);
			$obj->setActiveFrom($array['active_from_year']);
			$obj->setActiveTo($array['active_to_year']);
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
    
    function getWritersWithWritingSpouse(){
        $con = $this->getConnectionManager();
        $selectStmt = "Select p1.full_name as full_name_writer, p2.full_name as full_name_spouse, w1.active_from_year, w1.active_to_year
                        FROM person p1, person p2, writer w1, writer w2, is_spouse_of i
                        WHERE p1.uri = w1.writer_uri
                            and p2.uri = w2.writer_uri
                            and i.writer_uri = w1.writer_uri
                            and i.person_uri = w2.writer_uri";

        $spouse = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($spouse);
    }

}	


?>
