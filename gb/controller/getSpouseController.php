<?php
/**
 * Created by PhpStorm.
 * User: victo
 * Date: 7/04/2016
 * Time: 19:44
 */

namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/WriterMapper.php");

class getSpouseController extends pageController{
    private $selectedSpouses;

    function process()
    {
        $this->selectedSpouses = $this->searchSpouses(); 
    }
    
    function searchSpouses(){
        $mapper = new \gb\mapper\WriterMapper();
        return $mapper->getWritersWithWritingSpouse();
    }

    function getSearchResult() {
        return $this->selectedSpouses;
    }
}