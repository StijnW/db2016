<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php");
require_once("gb/mapper/ChapterMapper.php");

class SimilarBooksController extends PageController {
    
    private $selectedBookByGenre;
    private $selectedBooks = array();
        
    function process() {
                
        //if (isset($_POST["addbook"])) {
        //    print "book added".$_POST["addbook"];
        //    if (strlen($_POST["addbook"]) > 0){
        //        array_push($this->selectedBooks, $_POST["addbook"]);
        //    }
        //}
        
        if (isset($_POST["selectGenre"])) {
            if ((strlen($_POST["genre"])) > 0) {
                $this->selectedBookByGenre = $this->searchBookByGenre($_POST["genre"]);
            }
        }
        
        else if (isset($_POST["selectBook"])) {
            print "tried to book added";
            if ((strlen($_POST["book"])) > 0) {
                print "book added";
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
    
    function getFirstSelectedBookUri() {
        print_r($this->selectedBooks);
        print "no value returned";
        if (count($this->selectedBooks) > 0){
            print "value returned";
            return $this->selectedBooks[0];
        }
    }    
}

?>