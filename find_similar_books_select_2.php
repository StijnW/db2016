<?php
	
$title = "Find books you like";

require("template/top.tpl.php");
require_once("gb/controller/SimilarBooksController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");


$similarBooksController = new gb\controller\SimilarBooksController();
$similarBooksController->process();

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();
 
$firstBook = explode('=',$_SERVER['REQUEST_URI'])[1];
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
			<h4>Please select the second book you like</h4>
            <td>Genre</td>            
            <td colspan="3" style="width: 85%">
                <select style="width: 25%" name="genre">
                    <option value="">---------------- Book genres ----------------</option>
					<?php
                    foreach($allGenres as $genre) {
                        echo "<option value=\"", $genre->getUri(), "\">", $genre->getGenreName(), "</option>" ;
                    }
                    
                    ?>
                </select>
				<input type ="submit" name="selectGenre" value="Select Genre">
            </td>
        </tr>
		<tr>
            <td>Book</td>
            <td colspan="3" style="width: 85%">
                <select style="width: 25%" name="book">
                    <option value="">------------------ Books --------------------</option>
					<?php
					$books = $similarBooksController->getSelectedBookByGenre();
                    foreach($books as $book) {
                        echo "<option value=\"", $book->getUri(), "\">", $book->getBookName(), "</option>" ;
                    }
                    
                    ?>
                </select>
				<input type ="submit" name="selectBook" value="Select Book">
            </td>
        </tr>
			<td><span style="font-weight:bold">Current Books: </span><?php $selectedBook = $similarBooksController->getSelectedBookUri(); ?></td>
		</tr>
		<tr><td allign = "center"><?php $firstBookName = $similarBooksController->getBookNameByUri($firstBook);
		if (count($firstBookName) > 0){
					  echo "1. ".$firstBookName[0]->getBookName(); }?></td></tr>
		<tr><td allighn "center"><?php $selectedBookName = $similarBooksController->getBookNameByUri($selectedBook);
		if (count($selectedBookName) > 0){
					  echo "2. ".$selectedBookName[0]->getBookName(); }?></td></tr>
		<td><?php $link = "find_similar_books_select_3.php?bookuri1=".$firstBook."?bookuri2=".$similarBooksController->getSelectedBookUri() ?></td>
		<td align="right"><?php echo "<a href=$link>Select third book</a>";?></td>
    </table>
    </td>
</table>
</form>
</table>
	
<?php
	require("template/bottom.tpl.php");
?>