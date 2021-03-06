<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php");
require_once("gb/mapper/ChapterMapper.php");

class BookController extends PageController {
    private $selectedBookUri;
    private $selectedChapterNumber;
    private $chapterText;
        
    function process() {
        
        if (isset($_POST["search"])) {
            
            if ((strlen($_POST["genre"])) > 0){
                $this->selectedBookUri = $this->searchBookByGenre($_POST["genre"]);
            }
        }
        
        if (isset($_POST["update"])) {
            $array = explode('=',$_SERVER['REQUEST_URI']);
            $this->selectedBookUri = $array[1];
            $this->selectedChapterNumber = $_POST["chapter"];
            $this->updateBookChapter($_POST["new_text"],$this->getSelectedBookUri(),$this->selectedChapterNumber);
        }
        
        else if (isset($_POST["chapter"])){
                $array = explode(',',($_POST["chapter"]));
                $chapterText = $array[0];
                $selectedChapterNumber = $array[1];
                $selectedBookUri = $array[2];
                $this->selectedChapterNumber = $selectedChapterNumber;
                $this->selectedBookUri = $selectedBookUri;
                $this->chapterText = $chapterText;
        }
        
        if (isset($_POST["add_chapter"])) {
            $array = explode('=',$_SERVER['REQUEST_URI']);
            $this->selectedBookUri = $array[1];
			$this->selectedChapterNumber = $_POST["chapter_number"];
            $this->addBookChapter($_POST["new_text"], $this->selectedBookUri, $this->selectedChapterNumber);
        }
        
        if (isset($_GET["book_uri"])) {
            $this->selectedBookUri = $_GET["book_uri"];
        }
    }
    
    function updateBookChapter($new_text) {
        $mapper = new \gb\mapper\ChapterMapper();
        $mapper->updateChapterText($new_text, $this->selectedBookUri, $this->selectedChapterNumber);
    }
	
       function addBookChapter($new_text, $book_uri, $chapter_number) {
        $mapper = new \gb\mapper\ChapterMapper();
		$mapper->insertChapter($new_text, $book_uri, $chapter_number);
    }
	   
		
    function getSelectedBookUri() {
        return $this->selectedBookUri;
    }
        
    function searchBookByGenre($genre){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getBookByGenre($genre);
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