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
 
$secondBook = explode('2=',$_SERVER['REQUEST_URI'])[1];
$array = explode('?bookuri1=',$_SERVER['REQUEST_URI'])[1];
$firstBook = explode('?',$array)[0];
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
			<h4>Please select the third book you like</h4>
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
		<tr>
			<td><span style="font-weight:bold">Current Books: </span><?php $selectedBook = $similarBooksController->getSelectedBookUri(); ?></td>
		</tr>
		<tr><td allign = "center"><?php $firstBookName = $similarBooksController->getBookNameByUri($firstBook);
		if (count($firstBookName) > 0){
					  echo "1. ".$firstBookName[0]->getBookName(); }?></td></tr>
		<tr><td allighn "center"><?php $secondBookName = $similarBooksController->getBookNameByUri($secondBook);
		if (count($secondBookName) > 0){
					  echo "2. ".$secondBookName[0]->getBookName(); }?></td></tr>
		<tr><td allighn "center"><?php $selectedBookName = $similarBooksController->getBookNameByUri($selectedBook);
		if (count($selectedBookName) > 0){
					  echo "3. ".$selectedBookName[0]->getBookName(); }?></td></tr>
    </table>
    </td>
</table>
</form>
<h4><?php if (strlen($selectedBook) > 0) { echo "Results"; }?></h4>
<?php
	if (strlen($selectedBook) > 0){
	$firstFoundBooks = $similarBooksController->searchSimilarBooks($firstBook);
	$secondFoundBooks = $similarBooksController->searchSimilarBooks($secondBook);
	$thirdFoundBooks = $similarBooksController->searchSimilarBooks($selectedBook);
	$foundBooks = array_merge($firstFoundBooks,$secondFoundBooks,$thirdFoundBooks);
	//if you uncomment line 84 and comment lines 78-81, a search function based on the three given books will run
	//this function is slow, we prefer to use the function based on 1 book and merge the results.
	//$foundBooks = $similarBooksController->searchSimilarBooksBasedOnThree($firstBook,$secondBook,$selectedBook);
	if (count($foundBooks) > 0)
		{?>	
		<table style="width: 100%">
    <tr>
        <td><span style= "font-weight:bold">Book name</span></td>
        <td><span style= "font-weight:bold">Writer</span></td>
    </tr>   
<?php
		foreach($foundBooks as $foundBook){
			?>
			<tr>
			<td><?php echo $foundBook->getBookName(); ?></td>
			<td><?php echo $foundBook->getWriter(); ?></td>
			</tr>
<?php
		}
?>
</table>

<?php
		}
	}
?>

<?php
	require("template/bottom.tpl.php");
?>