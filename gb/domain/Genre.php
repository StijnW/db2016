<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Genre extends DomainObject {    
      
    private $uri;
    private $name;
    private $description;
    

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setUri( $uri ) {
        $this->iso_code = $uri;        
    }

    function getUri( ) {
        return $this->iso_code;
    }
    
    function setGenreName ( $name ) {
        $this->name = $name;
    }
    
    function getGenreName () {
        return $this->name;
    }
    
    function setDescription($description) {
        $this->description = $description;
    }
    
    function getDescription() {
        return $this->description;
    }

}

?>
