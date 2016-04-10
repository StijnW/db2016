<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class GenreCountry extends DomainObject {    
      
    private $uri;
    private $genre_name;
    private $country_name;
    private $number_awards;
   
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
	
	function setGenreName($genre_name) {
        $this->genre_name = $genre_name;
    }
    function getGenreName(  ) {
        return $this->genre_name;
	}
	
	function setCountryName($country_name) {
        $this->country_name = $country_name;
    }
    function getCountryName(  ) {
        return $this->country_name;
	}
	
	function setNumberAwards($number_awards) {
        $this->number_awards = $number_awards;
    }
    function getNumberAwards(  ) {
        return $this->number_awards;
	}
	}

?>