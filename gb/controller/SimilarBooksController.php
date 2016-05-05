<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php");
require_once("gb/mapper/ChapterMapper.php");

class SimilarBooksController extends PageController {
    
    private $selectedBookByGenre;
    private $selectedBooks = array();
        
    function process() {
                        
        if (isset($_POST["selectGenre"])) {
            if (strlen($_POST["genre"]) > 0) {
                $this->selectedBookByGenre = $this->searchBookByGenre($_POST["genre"]);
            }
        }
        
        else if (isset($_POST["selectBook"])) {
            if (strlen($_POST["book"]) > 0) {
                array_push($this->selectedBooks,$_POST["book"]);
            }
        }
    }
            
    function searchBookByGenre($genre){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getBookByGenre($genre);
    }
    
    function getSelectedBookByGenre(){
        return $this->selectedBookByGenre;
    }
    
    function getSelectedBookUris() {
        return $this->selectedBooks;
    }
    
    function getFirstSelectedBookUri(){
        if (count($this->selectedBooks) > 0){
            return $this->selectedBooks[0];
        }
    }
}

?>