<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/WriterMapper.php" );

class SearchWritersController extends PageController {
    private $writers;
    
    function process() {
        if (isset($_POST["search_writer"])) {
            
            if ((strlen($_POST["full_name"]) > 0) &&
                    (strlen($_POST["date_of_birth"]) == 0) &&
                    (strlen($_POST["country"])== 0))
                {            
                // search by full name                
                $this->writers = $this->searchWriterByName($_POST["full_name"]);
            } else if ((strlen($_POST["full_name"]) > 0) &&
                        (strlen($_POST["date_of_birth"]) > 0) &&
                        (strlen($_POST["country"])== 0)) {
                // search by full name + date_of_birth
                $this->writers = $this->searchWriterByNameAndDoB($_POST["full_name"], $_POST["date_of_birth"]);
            } else if ((strlen($_POST["full_name"]) > 0) &&
                        (strlen($_POST["date_of_birth"]) > 0) &&
                        (strlen($_POST["country"]) > 0)) {
                // search by full name + date_of_birth + country
                $this->writers = $this->searchWriterByNameAndDoBAndCountry($_POST["full_name"],
                                            $_POST["date_of_birth"], $_POST["country"]);
                
            } else {
                // list all writers
                $this->writers = $this->listAllWriters();
            }
            
        } 
    }
    
    function searchWriterByName($name) {
        $mapper = new \gb\mapper\WriterMapper();
        return $mapper->getWritersByName($name);
    }
    
    function searchWriterByNameAndDoB($name, $dob) {
        $mapper = new \gb\mapper\WriterMapper();
        return $mapper->getWritersByNameAndDoB($name, $dob);
    }
    
    function searchWriterByNameAndDoBAndCountry($name, $date_of_birth, $country) {
        $mapper = new \gb\mapper\WriterMapper();
        return $mapper->getWritersByNameAndDoBAndCountry($name, $date_of_birth, $country);
    }
    
    function listAllWriters() {
        $mapper = new \gb\mapper\WriterMapper();
        return $mapper->getAllWriters();
    }
    
    function getSearchResult() {
        return $this->writers;
    }
}

?>