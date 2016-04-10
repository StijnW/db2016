// Query to excecute : "SELECT g.name, c.name, COUNT(*)
// FROM country c, award a, genre g, book b, wins_award wa, writer w, person p, has_citizenship hc, writes ws
// WHERE wa.book_uri = b.uri
// and wa.genre_uri = g.uri
// and wa.award_uri = a.uri
// and w.writer_uri = p.uri
// and p.uri = hc.person_uri
// and c.iso_code = hc.country_iso_code
// and w.writer_uri = ws.writer_uri
// and ws.book_uri = b.uri
// and b.first_publication_date < '$End_date'
// and b.first_publication_date > '$Start_date'
// GROUP BY  g.name, c.iso_code";

<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/GenreCountry.php" );

class GenreCountryMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT g.name, c.name, COUNT(*)
								 FROM country c, award a, genre g, book b, wins_award wa, writer w, person p, has_citizenship hc, writes ws
								 WHERE wa.book_uri = b.uri
								 and wa.genre_uri = g.uri
								 and wa.award_uri = a.uri
								 and w.writer_uri = p.uri
								 and p.uri = hc.person_uri
								 and c.iso_code = hc.country_iso_code
								 and w.writer_uri = ws.writer_uri
								 and ws.book_uri = b.uri
								 and b.first_publication_date < ?
								 and b.first_publication_date > ?
								 GROUP BY  g.name, c.iso_code";
        $this->selectAllStmt = "SELECT g.name, c.name, COUNT(*)
								 FROM country c, award a, genre g, book b, wins_award wa, writer w, person p, has_citizenship hc, writes ws
								 WHERE wa.book_uri = b.uri
								 and wa.genre_uri = g.uri
								 and wa.award_uri = a.uri
								 and w.writer_uri = p.uri
								 and p.uri = hc.person_uri
								 and c.iso_code = hc.country_iso_code
								 and w.writer_uri = ws.writer_uri
								 and ws.book_uri = b.uri";        
    } 
    
    function getCollection( array $raw ) {
        
        $genreCountryCollection = array();
        foreach($raw as $row) {
            array_push($genreCountryCollection, $this->doCreateObject($row));
        }
        
        return $genreCountryCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\GenreCountry($array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setGenre($array['genre']);
            $obj->setCountry($array['country']);
            $obj->setNumberAwards($array['number_awards']);
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
    
    function getGenreCountryAwards ($Start_date, $End_date) {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT g.name, c.name, COUNT(*)
								 FROM country c, award a, genre g, book b, wins_award wa, writer w, person p, has_citizenship hc, writes ws
								 WHERE wa.book_uri = b.uri
								 and wa.genre_uri = g.uri
								 and wa.award_uri = a.uri
								 and w.writer_uri = p.uri
								 and p.uri = hc.person_uri
								 and c.iso_code = hc.country_iso_code
								 and w.writer_uri = ws.writer_uri
								 and ws.book_uri = b.uri
								 and b.first_publication_date < '$End_date'
								 and b.first_publication_date > '$Start_date'
								 GROUP BY  g.name, c.iso_code";        
        $genreCountrys = $con->executeSelectStatement($selectStmt, array()); 
        return $this->getCollection($genreCountrys);
		
		}	

}
?>