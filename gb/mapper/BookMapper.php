<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Book.php" );


class BookMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT b.* FROM book b where b.uri = ?";
        $this->selectAllStmt = "SELECT * FROM book";        
    } 
    
    function getCollection( array $raw ) {
        
        $bookCollection = array();
        foreach($raw as $row) {
            #print_r($row);
            array_push($bookCollection, $this->doCreateObject($row));
        }
        
        return $bookCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Book( $array['name'] );
			if (array_key_exists('uri', $array)){
				$obj->setUri($array["uri"]);}
            $obj->setBookName($array["name"]);
			if (array_key_exists('description', $array)){
				$obj->setDescription($array['description']);
			}
			if (array_key_exists('COUNT(*)', $array)){
				$obj->setNumberAwards($array["COUNT(*)"]);
			}
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
    
    function getBookByGenre($genre){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT b.name, b.uri,  COUNT(*), b.description
		    			 FROM award a, book b, wins_award c, has_genre d, genre e
						 WHERE c.book_uri = b.uri
							 and c.award_uri = a.uri
							 and b.uri = d.book_uri
							 and d.genre_uri = e.uri
							 and e.uri = '$genre'
                        GROUP BY b.name";
        $books = $con->executeSelectStatement($selectStmt, array()); 
        return $this->getCollection($books);
    }
	
	function getBookNameByUri($uri){
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT b.name
						FROM book b
						WHERE b.uri = '$uri'";
		$book = $con->executeSelectStatement($selectStmt, array());
		return $this->getCollection($book);
	}
	
	function getSimilarBooks($firstBook,$secondBook,$thirdBook){
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT b.name
						FROM book b
						WHERE b.uri = '$firstBook' or
						b.uri = '$secondBook' or b.uri = '$thirdBook' ";
		$book = $con->executeSelectStatement($selectStmt, array());
		return $this->getCollection($book);
	}
}


?>
