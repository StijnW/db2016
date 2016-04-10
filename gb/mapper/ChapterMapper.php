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
			if(array_key_exists('chapter_number', $array)){
				$obj->setChapterNumber($array["chapter_number"]);}
            $obj->setText($array['text']);
			if(array_key_exists('COUNT(*)', $array)){
				$obj->setNumberOfChapters($array['COUNT(*)']);}
			if(array_key_exists('name', $array)){
				$obj->setBookName($array['name']);}
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
	
	function getAllChapters($book_uri){
		$con = $this->getConnectionManager();
        $selectStmt = "SELECT *
						FROM chapter c
						WHERE c.book_uri = '$book_uri'";
        $chapters = $con->executeSelectStatement($selectStmt, array()); 
        return $this->getCollection($chapters);
	}
    
	function updateChapterText($new_text, $book_uri, $chapter_number){
		$con = $this->getConnectionManager();
		$setStmt = "UPDATE chapter
					SET text = '$new_text'
					WHERE book_uri = '$book_uri' and chapter_number = '$chapter_number' ";
		$chapters = $con->executeUpdateStatement($setStmt, array()); 
	}
	
//	function executeUpdateStatement ($updateString, $paras) {
//        $stmt = $this->prepareSQLStatement ($updateString);
//        $stmt->execute($paras);
//        return $stmt->rowCount();
	
}
?>
