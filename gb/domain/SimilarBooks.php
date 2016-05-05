<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class SimilarBooks extends DomainObject {    
      
    private $uri;
    private $writer_name;
    private $book_name;
   
    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setUri($uri) {
        $this->uri = $uri;
    }
    function getUri(  ) {
        return $this->uri;
	}
	
	function setWriterName($writer_name) {
        $this->writer_name = $writer_name;
    }
    function getWriterName(  ) {
        return $this->writer_name;
	}
	
	function setBookName($book_name) {
        $this->book_name = $book_name;
    }
    function getBookName(  ) {
        return $this->book_name;
	}
	}

?>