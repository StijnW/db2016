<?php
	
$title = "Search books by genres";

require("template/top.tpl.php");
require_once("gb/controller/BookController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");


$bookController = new gb\controller\BookController();
$bookController->process();

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();
 
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
            <td>Genre</td>            
            <td colspan="3" style="width: 85%">
                <select style="width: 50%" name="genre">
                    <option value="">--------Book genres ---------- </option>
					<?php
                    foreach($allGenres as $genre) {
                        echo "<option value=\"", $genre->getUri(), "\">", $genre->getGenreName(), "</option>" ;
						//echo '<option value="'.$genre->getUri().'">'.$genre->getGenreName().'</option>';
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
	$books = $bookController->getSearchResult();
	print count($books) . " books found";
	if (count($books) > 0)
	{?>	
		<table style="width: 100%">
    <tr>
        <td>Book name</td>        
        <td>Awards</td>
        <td>Description</td>
    </tr>   
<?php
		foreach($books as $book){
			?>
			<tr>
			<td><?php echo $book->getBookName(); ?></td>
			<td><?php echo $book->getNumberAwards(); ?></td>
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