<?php

require_once("gb/controller/SimilarBooksController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");


$similarBooksController = new gb\controller\SimilarBooksController();
$similarBooksController->process();

require("template/top.tpl.php");

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();
 
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
                    <option value="">--------Book genres ---------- </option>
					<?php
                    foreach($allGenres as $genre) {
                        echo "<option value=\"", $genre->getUri(), "\">", $genre->getGenreName(), "</option>" ;
                    }
                    
                    ?>
                </select>
            </td>          
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td><input type ="submit" name="search" value="Search" ></td>
            <td >&nbsp;</td>
    
        </tr>
    </table>
    </td>
</table>
</form>

<?php
	$books = $similarBooksController->getSelectedBookUri();
	print count($books) . " books found";
	if (count($books) > 0)
	{?>	
		<table style="width: 100%">
    <tr>
        <td>Book name</td>        
        <td>Description</td>
    </tr>   
<?php
		print $similarBooksController->getFirstSelectedBookUri();
		$books = $similarBooksController->getSelectedBookUri();
		foreach($books as $book){
			?>
			<tr>
            <td><?php
				print $book->getUri();
				$first_book_uri=explode('=',$_SERVER['REQUEST_URI']);
				$link = "find_similar_books_select_3.php?book_uri1=".$first_book_uri[1]."?book_uri2=".$book->getUri();
				$book_name = $book->getBookName();
				echo "<a href=$link>$book_name</a>";?></td>    
			<td><?php echo $book->getDescription(); ?></td>
			</tr>
<?php
		}
?>
</table>
<?php
	}
?>
	
	
<?php
	require("template/bottom.tpl.php");
?>