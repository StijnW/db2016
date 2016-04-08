<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Chapter extends DomainObject {    
      
    private $uri;
    private $chapter_number;
    private $text;
    private $number_of_chapters;
    private $book_name;
   
    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setUri($uri) {
        $this->uri = $uri;
    }
    function getUri() {
        return $this->uri;
    }
       
    function setChapterNumber ( $chapter_number ) {
        $this->chapter_number = $chapter_number;        
    }
    
    function getChapterNumber () {
        return $this->chapter_number;
    }
    
    function setText( $text) {
        $this->text = $text;
    }
    
    function getText () {
        return $this->text;
    }
    
    function setNumberOfChapters($number_of_chapters){
        $this->number_of_chapters = $number_of_chapters;
    }
    
    function getNumberOfChapters(){
        return $this->number_of_chapters;
    }
    
    function setBookName($book_name){
        $this->book_name = $book_name;
    }
    
    function getBookName(){
        return $this->book_name;
    }
}

?>
