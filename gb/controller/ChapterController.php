<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/ChapterMapper.php");


class ChapterController extends PageController {
    private $selectedBookUri;
    
    function process() {
        if (isset($_POST["search"])) {
            if ((strlen($_POST["genre"])) > 0){
                $this->selectedBookUri = $this->searchByGenre($_POST["genre"]);
            }
        }
    }
    
    function searchByGenre($genre){
        $mapper = new \gb\mapper\ChapterMapper();
        return $mapper->getBookAndNumberOfChaptersByGenre($genre);
    }
    
    function getSelectedBooks(){
        return $this->selectedBookUri;
    }
    
}

?>