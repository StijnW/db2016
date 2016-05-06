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
 
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
			<h4>Please select the first book you like</h4>
            <td>Genre</td>            
            <td colspan="3" style="width: 85%">
                <select style="width: 25%" name="genre">
                    <option value="">-------------- Book genres --------------</option>
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
                    <option value="">----------------- Books -----------------</option>
					<?php
					$books = $similarBooksController->getSelectedBookByGenre();
                    foreach($books as $book) {
                        echo "<option value=\"", $book->getUri(), "\">", $book->getBookName(), "</option>" ;
                    }
                    
                    ?>
                </select><input type ="submit" name="selectBook" value="Select Book">
            </td>
        </tr>
		<td>Current Books: <?php $selectedBook = $similarBooksController->getSelectedBookUri();
		echo $selectedBook;?></td>
		<td><?php $link = "find_similar_books_select_2.php?bookuri1=".$similarBooksController->getSelectedBookUri() ?></td>
		<td align="right"><?php echo "<a href=$link>Select second book</a>";?></td>
    </table>
    </td>
</table>
</form>
</table>
	
<?php
	require("template/bottom.tpl.php");
?>