<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Book extends DomainObject {    
      
    private $uri;
    private $name;
    private $description;
    private $originalLanguage;
    private $firstPublicationDate;
    private $numberAwards;
    private $numberOfChapters;
    private $writer;
   
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
       
    function setBookName ( $name ) {
        $this->name = $name;        
    }
    
    function getBookName () {
        return $this->name;
    }
    
    function setDescription( $description) {
        $this->description = $description;
    }
    
    function getDescription () {
        return $this->description;
    }
    
    function setOriginalLanguage ($original_language) {
        $this->orignalLanguage = $original_language;
    }
    
    function getOriginalLanguage() {
        return $this->originalLanguage;
    }
    
    function setFirstPublicationDate( $first_publication_date) {
        $this->firstPublicationDate = $first_publication_date;
    }
    
    function getFirstPublicationDate() {
        return $this->firstPublicationDate;
    }

    function setNumberAwards( $number_awards){
        $this->numberAwards = $number_awards;
    }

    function getNumberAwards(){
        return $this->numberAwards;
    }
    
    function setNumberOfChapters($number_of_chapters){
        $this->numberOfChapters = $number_of_chapters;
    }
    
    function getNumberOfChapters(){
        return $this->numberOfChapters;
    }
    
    function setWriter($writer){
        $this->writer = $writer;
    }
    
    function getWriter(){
        return $this->writer;
    }
}

?>
