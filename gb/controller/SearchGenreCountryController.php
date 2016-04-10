<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/GenreCountryMapper.php" );

class SearchGenreCountryController extends PageController {
    private $genreCountrys;
    
    function process() {
        if (isset($_POST["search_genre_countrys"])) {             
            $this->genreCountrys = $this->searchGenreCountry($_POST["start_date"], $_POST["end_date"]);
            } 
	}
	
	function searchGenreCountry($start_date, $end_date) {
        $mapper = new \gb\mapper\GenreCountryMapper();
        return $mapper->getGenreCountryAwards ($start_date, $end_date);
    }
	
	    function getSearchResult() {
        return $this->genreCountrys;
    }
}

?>