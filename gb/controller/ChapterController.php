<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require("gb/mapper/ChapterMapper.php");


class ChapterController extends PageController {
    private $selectedBookUri;
    private $selectedChapterNumber;
    private $chapterText;
    
    function process() {
        if (isset($_POST["search"])) {
            if ((strlen($_POST["genre"])) > 0){
                $this->selectedBookUri = $this->searchByGenre($_POST["genre"]);
            }
        }
        if (isset($_POST["chapter"])){
                $array = explode(',',($_POST["chapter"]));
                $chapterText = $array[0];
                $this->selectedChapterNumber = $array[1];
                $this->selectedBookUri = $array[2];
                $this->chapterText = $chapterText;
            
        }
    }
    
    function searchByGenre($genre){
        $mapper = new \gb\mapper\ChapterMapper();
        return $mapper->getBookAndNumberOfChaptersByGenre($genre);
    }
    
    function getSelectedBooks(){
        return $this->selectedBookUri;
    }
        
    function getChapterText(){
        return $this->chapterText;
    }
}

?>