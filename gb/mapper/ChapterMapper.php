<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Chapter.php" );


class ChapterMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM chapter where book_uri = ? and chapter_number = ?";
        $this->selectAllStmt = "SELECT * FROM chapter order by book_uri";        
    } 
    
    function getCollection( array $raw ) {
        
        $customerCollection = array();
        foreach($raw as $row) {
            array_push($customerCollection, $this->doCreateObject($row));
        }
        
        return $customerCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Chapter( $array['book_uri']);
            
            $obj->setUri($array['book_uri']);
            $obj->setChapterNumber($array["chapter_number"]);
            $obj->setText($array['text']);
            $obj->setNumberOfChapters($array['COUNT(*)']);
            $obj->setBookName($array['name']);
            
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
    
    function getBookAndNumberOfChaptersByGenre($genre){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT b.name, c.*, COUNT(*)
						FROM book b, has_genre d, genre e, chapter c
						WHERE b.uri = d.book_uri
							and d.genre_uri = e.uri
							and e.uri = '$genre'
							and b.uri = c.book_uri
						GROUP BY b.name";
        $books = $con->executeSelectStatement($selectStmt, array()); 
        return $this->getCollection($books);
    }
    
}


?>
