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
 
 $secondBookLink = explode('2=',$_SERVER['REQUEST_URI'])[1];

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
                <select style="width: 50%" name="genre">
                    <option value="">-------- Book genres ----------</option>
					<?php
                    foreach($allGenres as $genre) {
                        echo "<option value=\"", $genre->getUri(), "\">", $genre->getGenreName(), "</option>" ;
                    }
                    
                    ?>
                </select>
            </td>
			<td><input type ="submit" name="selectGenre" value="Select Genre"></td>
        </tr>
		<tr>
            <td>Book</td>
            <td colspan="3" style="width: 85%">
                <select style="width: 50%" name="book">
                    <option value="">--------Books----------</option>
					<?php
					$books = $similarBooksController->getSelectedBookByGenre();
                    foreach($books as $book) {
                        echo "<option value=\"", $book->getUri(), "\">", $book->getBookName(), "</option>" ;
                    }
                    
                    ?>
                </select>
            </td>
			<td><input type ="submit" name="selectBook" value="Select Book"></td>
        </tr>
		<tr>
			<td>Current Books: <?php $selectedBook = $similarBooksController->getSelectedBookUri();
			echo $firstBook;
			echo $selectedBook?></td>
		</tr>
		<td><?php $link = "find_similar_books_select_3.php?bookuri1=".$secondBook."?bookuri2=".$similarBooksController->getFirstSelectedBookUri() ?></td>
		<td><?php echo "<a href=$link>Select third book</a>";?></td>
    </table>
    </td>
</table>
</form>
</table>
	
<?php
	require("template/bottom.tpl.php");
?>