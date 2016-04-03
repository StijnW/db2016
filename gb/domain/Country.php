<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Country extends DomainObject {    
      
    private $iso_code;
    private $name;
    private $description;
    

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setIsoCode( $code ) {
        $this->iso_code = $code;        
    }

    function getIsoCode( ) {
        return $this->iso_code;
    }
    
    function setCountryName ( $name ) {
        $this->name = $name;
    }
    
    function getCountryName () {
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
