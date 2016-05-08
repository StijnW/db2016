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
			if (array_key_exists('full_name', $array)){
				$obj->setWriter($array["full_name"]);
			}
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
	
	function getSimilarBooks($selectedBook){
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT monsterlijst.name, monsterlijst.full_name, COUNT(*)
						FROM
						(
						SELECT stijlschrijver.book_uri, stijlschrijver.writer_uri, stijlschrijver.genre_uri, prijs.award_uri
						FROM
						(
						SELECT schrijver.book_uri, schrijver.writer_uri, stijl.genre_uri FROM
						(
							SELECT writes.writer_uri, writes.book_uri
							FROM writes
							WHERE writes.book_uri = '$selectedBook'
						) schrijver
						LEFT JOIN
						 (
							SELECT has_genre.genre_uri, has_genre.book_uri
							FROM has_genre
							WHERE has_genre.book_uri = '$selectedBook'
						)  
						stijl
						ON schrijver.book_uri = stijl.book_uri
						) stijlschrijver
						LEFT JOIN
						(
							SELECT wins_award.award_uri, wins_award.book_uri
							FROM wins_award
							WHERE wins_award.book_uri = '$selectedBook'
						) 
						prijs
						ON prijs.book_uri=stijlschrijver.book_uri
						) gegevenboek
						,
						(
						SELECT boekpersoongenreaward.uri, boekpersoongenreaward.full_name, boekpersoongenreaward.book_uri, boekpersoongenreaward.name, boekpersoongenreaward.genre_uri, boekpersoongenreaward.award_uri
						FROM
						(
							SELECT boekpersoongenre.uri, boekpersoongenre.full_name, boekpersoongenre.book_uri, boekpersoongenre.name, boekpersoongenre.genre_uri,  prijs.award_uri
							FROM
							(
								SELECT boekenenpersonen.uri, boekenenpersonen.full_name, boekenenpersonen.book_uri, boekenenpersonen.name, has_genre.genre_uri
								FROM
								(
									SELECT personenmetboeken.uri, personenmetboeken.full_name, personenmetboeken.book_uri, boek.name
									FROM
									(
										SELECT mensen.uri, mensen.full_name, writes.book_uri 
										FROM 
										(
											writes 	
											Left Join 
											(	
												(
												 SELECT person.uri, person.full_name FROM person
												) 
												mensen
												JOIN 
												(
													SELECT writer.writer_uri FROM writer
												) 
												schrijvers
												ON mensen.uri=schrijvers.writer_uri
											)
											ON writes.writer_uri=mensen.uri
										)
									)
									personenmetboeken JOIN   
									(
									SELECT book.name, book.uri FROM book
									)
									boek ON personenmetboeken.book_uri=boek.uri
								)
								boekenenpersonen 
								Left JOIN has_genre 
								ON has_genre.book_uri=boekenenpersonen.book_uri	
							)
							boekpersoongenre 
							LEFT JOIN
							(
								SELECT wins_award.book_uri, wins_award.award_uri FROM wins_award
							)
							prijs
							ON boekpersoongenre.book_uri=prijs.book_uri
						)
						boekpersoongenreaward
						)    monsterlijst
						WHERE
						monsterlijst.uri = gegevenboek.writer_uri OR monsterlijst.genre_uri=gegevenboek.genre_uri OR monsterlijst.award_uri=gegevenboek.award_uri
						GROUP BY monsterlijst.uri
						ORDER BY COUNT(*) DESC";
		$book = $con->executeSelectStatement($selectStmt, array());
		return $this->getCollection($book);
	}
	
	//This version is slow, but it works. We prefer to use the version above three times and merge the results.
	//You can use this version by uncommenting line 84 and commenting lines 78-81, in find_similar_books_selected_3.php
	function getSimilarBooksBasedOnThree($firstBook, $secondBook, $thirdBook){
		$con = $this->getConnectionManager();
		$selectStmt = "SELECT monsterlijst.name, monsterlijst.full_name, COUNT(*)
				FROM
				(
					SELECT stijlschrijver.book_uri, stijlschrijver.writer_uri, stijlschrijver.genre_uri, prijs.award_uri
					FROM
					(
						SELECT schrijver.book_uri, schrijver.writer_uri, stijl.genre_uri FROM
						(
							SELECT writes.writer_uri, writes.book_uri
							FROM writes
							WHERE writes.book_uri = '$firstBook'
						) schrijver
						LEFT JOIN
						 (
							SELECT has_genre.genre_uri, has_genre.book_uri
							FROM has_genre
							WHERE has_genre.book_uri = '$firstBook'
						)  
						stijl
						ON schrijver.book_uri = stijl.book_uri
					 ) stijlschrijver
					LEFT JOIN
						(
							SELECT wins_award.award_uri, wins_award.book_uri
							FROM wins_award
							WHERE wins_award.book_uri = '$firstBook'
						) 
						prijs
						ON prijs.book_uri=stijlschrijver.book_uri
				) gegevenboek1
				,
				(
					SELECT stijlschrijver.book_uri, stijlschrijver.writer_uri, stijlschrijver.genre_uri, prijs.award_uri
					FROM
					(
						SELECT schrijver.book_uri, schrijver.writer_uri, stijl.genre_uri FROM
						(
							SELECT writes.writer_uri, writes.book_uri
							FROM writes
							WHERE writes.book_uri = '$secondBook'
						) schrijver
						LEFT JOIN
						 (
							SELECT has_genre.genre_uri, has_genre.book_uri
							FROM has_genre
							WHERE has_genre.book_uri = '$secondBook'
						)  
						stijl
						ON schrijver.book_uri = stijl.book_uri
					 ) stijlschrijver
					LEFT JOIN
						(
							SELECT wins_award.award_uri, wins_award.book_uri
							FROM wins_award
							WHERE wins_award.book_uri = '$secondBook'
						) 
						prijs
						ON prijs.book_uri=stijlschrijver.book_uri
				) gegevenboek2
				,
				(
					SELECT stijlschrijver.book_uri, stijlschrijver.writer_uri, stijlschrijver.genre_uri, prijs.award_uri
					FROM
					(
						SELECT schrijver.book_uri, schrijver.writer_uri, stijl.genre_uri FROM
						(
							SELECT writes.writer_uri, writes.book_uri
							FROM writes
							WHERE writes.book_uri = '$thirdBook'
						) schrijver
						LEFT JOIN
						 (
							SELECT has_genre.genre_uri, has_genre.book_uri
							FROM has_genre
							WHERE has_genre.book_uri = '$thirdBook'
						)  
						stijl
						ON schrijver.book_uri = stijl.book_uri
					 ) stijlschrijver
					LEFT JOIN
						(
							SELECT wins_award.award_uri, wins_award.book_uri
							FROM wins_award
							WHERE wins_award.book_uri = '$thirdBook'
						) 
						prijs
						ON prijs.book_uri=stijlschrijver.book_uri
				) gegevenboek3
				,
				(
					SELECT boekpersoongenreaward.uri, boekpersoongenreaward.full_name, boekpersoongenreaward.book_uri, boekpersoongenreaward.name, boekpersoongenreaward.genre_uri, boekpersoongenreaward.award_uri
					FROM
						(
							SELECT boekpersoongenre.uri, boekpersoongenre.full_name, boekpersoongenre.book_uri, boekpersoongenre.name, boekpersoongenre.genre_uri,  prijs.award_uri
							FROM
							(
								SELECT boekenenpersonen.uri, boekenenpersonen.full_name, boekenenpersonen.book_uri, boekenenpersonen.name, has_genre.genre_uri
								FROM
								(
									SELECT personenmetboeken.uri, personenmetboeken.full_name, personenmetboeken.book_uri, boek.name
									FROM
									(
										SELECT mensen.uri, mensen.full_name, writes.book_uri 
										FROM 
										(
											writes 	
											Left Join 
											(	
												(
												 SELECT person.uri, person.full_name FROM person
												) 
												mensen
												JOIN 
												(
													SELECT writer.writer_uri FROM writer
												) 
												schrijvers
												ON mensen.uri=schrijvers.writer_uri
											)
											ON writes.writer_uri=mensen.uri
										)
									)
									personenmetboeken JOIN   
									(
									SELECT book.name, book.uri FROM book
									)
									boek ON personenmetboeken.book_uri=boek.uri
								)
								boekenenpersonen 
								Left JOIN has_genre 
								ON has_genre.book_uri=boekenenpersonen.book_uri	
							)
							boekpersoongenre 
							LEFT JOIN
							(
								SELECT wins_award.book_uri, wins_award.award_uri FROM wins_award
							)
							prijs
							ON boekpersoongenre.book_uri=prijs.book_uri
						)
						boekpersoongenreaward
				)    monsterlijst
				WHERE
				NOT monsterlijst.book_uri = gegevenboek1.book_uri
				AND NOT monsterlijst.book_uri = gegevenboek2.book_uri
				AND NOT monsterlijst.book_uri = gegevenboek3.book_uri
				AND
				(monsterlijst.uri = gegevenboek1.writer_uri OR monsterlijst.genre_uri=gegevenboek1.genre_uri OR monsterlijst.award_uri=gegevenboek1.award_uri OR
				monsterlijst.uri = gegevenboek2.writer_uri OR monsterlijst.genre_uri=gegevenboek2.genre_uri OR monsterlijst.award_uri=gegevenboek2.award_uri OR
				monsterlijst.uri = gegevenboek3.writer_uri OR monsterlijst.genre_uri=gegevenboek3.genre_uri OR monsterlijst.award_uri=gegevenboek3.award_uri)
				GROUP BY monsterlijst.book_uri
				ORDER BY COUNT(*) DESC";
		$book = $con->executeSelectStatement($selectStmt, array());
		return $this->getCollection($book);
	}
	
}


?>
