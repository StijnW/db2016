<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Writer extends DomainObject {    
      
    private $uri;
    private $full_name;
    private $birth_date;
    private $death_date;
    private $description;
   
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
       
    function setFullName ( $full_name ) {
        $this->full_name = $full_name;        
    }
    
    function getFullName () {
        return $this->full_name;
    }
    
    function setDescription( $description) {
        $this->description = $description;
    }
    
    function getDescription () {
        return $this->description;
    }
    
    function setDateOfBirth ($date_of_birth) {
        $this->birth_date = $date_of_birth;
    }
    
    function getDateOfBirth() {
        return $this->birth_date;
    }
    
    function setDateofDeath( $date_of_death) {
        $this->death_date = $date_of_death;
    }
    
    function getDateOfDeath() {
        return $this->death_date;
    }

}

?>
