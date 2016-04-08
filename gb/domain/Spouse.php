<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Spouse extends DomainObject {    
      
    private $full_name;
    private $spouse;
    private $active_from;
    private $active_to;
   
    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setFullName ( $full_name ) {
        $this->full_name = $full_name;        
    }
    
    function getFullName () {
        return $this->full_name;
    }
 
	function setSpouse( $spouse){
        $this->spouse = $spouse;
    }

    function getSpouse(){
        return $this->spouse;
    }

    function setActiveFrom( $activeFrom){
        $this->active_from = $activeFrom;
    }

    function getActiveFrom(){
        return $this->active_from;
    }

    function setActiveTo ( $activeTo){
        $this->active_to = $activeTo;
    }

    function getActiveTo(){
        return $this->active_to;
    }

}

?>