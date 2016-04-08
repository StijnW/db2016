<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php");

class BookController extends PageController {
    private $selectedBookUri;
    
    function process() {
        if (isset($_POST["search"])) {
            
            if ((strlen($_POST["genre"])) > 0){
                $this->selectedBookUri = $this->searchBookByGenre($_POST["genre"]);
            }
        }
        
        if (isset($_POST["update"])) {
            $this->updateBookChapter();
        }
        
        if (isset($_POST["add_chapter"])) {
            $this->addBookChapter();
        }
        
        if (isset($_GET["book_uri"])) {
            $this->selectedBookUri = $_GET["book_uri"];
        }
    }
    
    function updateBookChapter() {
        print "Please provide some piece of code to update the book chapter here!";
    }
    function addBookChapter() {
        print "Please provide some piece of code to add a new chapter for the selected books here!";
    }
    
    function getSelectedBookUri() {
        return $this->selectedBookUri;
    }
    
    function searchBookByGenre($genre){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getBookByGenre($genre);
    }
}

?>