<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/GenreCountryMapper.php" );

class SearchGenreCountryController extends PageController {
    private $genreCountrys;
    
    function process() {
        if (isset($_POST["search_genre_country"])) {             
            $this->genreCountrys = $this->searchGenreCountry($_POST["from_time"], $_POST["to_time"]);
            } 
	}
	
	function searchGenreCountry($start_date, $end_date) {
		"SearchGenreCountry";
        $mapper = new \gb\mapper\GenreCountryMapper();
        return $mapper->getGenreCountryAwards ($start_date, $end_date);
    }
	
	    function getSearchResult() {
        return $this->genreCountrys;
    }
}

?>