<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/SpouseMapper.php");

class getSpouseController extends pageController{
    private $selectedSpouses;

    function process()
    {
        $this->selectedSpouses = $this->searchSpouses(); 
    }
    
    function searchSpouses(){
        $mapper = new \gb\mapper\SpouseMapper();
        return $mapper->getWritersWithWritingSpouse();
    }

    function getSearchResult() {
        return $this->selectedSpouses;
    }
}