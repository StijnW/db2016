<?php
	
$title = "Update chapters of books";

require("template/top.tpl.php");
require_once("gb/controller/ChapterController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");

$chapterController = new gb\controller\ChapterController();
$chapterController->process();

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
	$books_and_nb_chapters = $chapterController->getSelectedBooks();
	print count($books_and_nb_chapters) . " books found";
	if (count($books_and_nb_chapters) > 0)
	{?>	
	<table style="width: 100%">
		<tr>
			<td>Book name</td>
			<td>Chapters</td>
			<td>Add chapters</td>       
		</tr>
		<?php
			foreach($books_and_nb_chapters as $book_and_nb_chapters){
				?>
				<tr>
				<td><?php
				$link = "update_book_chapters.php?book_uri=".$book_and_nb_chapters->getUri();
				$book_name = $book_and_nb_chapters->getBookName();
				echo "<a href=$link>$book_name</a>";?></td>
				<td><?php
				$link = "update_book_chapters.php?book_uri=".$book_and_nb_chapters->getUri();
				$number_of_chapters = $book_and_nb_chapters->getNumberOfChapters();
				echo "<a href=$link>$number_of_chapters</a>";?></td>
				<td><?php
				$link = "add_book_chapters.php?book_uri=".$book_and_nb_chapters->getUri();
				echo "<a href=$link>Add chapter</a>";?></td>
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