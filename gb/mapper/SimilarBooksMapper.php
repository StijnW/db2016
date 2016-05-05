<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/SimilarBooks.php" );


class SimilarBooksMapper extends Mapper {

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
            $obj = new \gb\domain\SimilarBooks( $array['full_name_writer'] );

            $obj->setWriterName($array['full_name_writer']);
			$obj->setBookName($array['name_book']);
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
    
    function getSimilarBooks($book_uri_1){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT b.name, p.full_name, COUNT(*)
FROM book b, writer w, person p, writes ws, genre g, has_genre hg, wins_award wa, award a,
	book b1, writer w1, person p1, writes ws1, genre g1, has_genre hg1, wins_award wa1, award a1

WHERE b1.uri = '$book_uri_1'  
    AND w1.writer_uri = p1.uri
    AND ws1.writer_uri = w1.writer_uri
    AND ws1.book_uri = b1.uri
    AND b1.uri = hg1.book_uri
    AND g1.uri = hg1.genre_uri
    AND a1.uri = wa1.award_uri
    AND b1.uri = wa1.book_uri
    
    AND w.writer_uri = p.uri
    AND ws.writer_uri = w.writer_uri
    AND ws.book_uri = b.uri
    AND b.uri = hg.book_uri
    AND g.uri = hg.genre_uri
    AND a.uri = wa.award_uri
    AND b.uri = wa.book_uri
    AND (w.writer_uri = w1.writer_uri OR g.uri = g1.uri OR a.uri = a1.uri)
    
GROUP BY b.uri
ORDER BY COUNT(*) DESC";

        $similar_books = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($similar_books);
    }

}	


?>
