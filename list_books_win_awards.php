
<?php
	
$title = "Books win awards";

require("template/top.tpl.php");
require_once("gb/controller/SearchGenreCountryController.php");
require_once("gb/domain/GenreCountry.php");
require_once("gb/mapper/GenreCountryMapper.php");

$searchGenreCountryController = new gb\controller\SearchGenreCountryController();
$searchGenreCountryController->process();

$GenreCountryMapper = new gb\mapper\GenreCountryMapper();
$allGenreCountries = $GenreCountryMapper->findAll();
 
?>      
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
     
         <tr>
            <td>From time</td>
            <td><input type="text" name ="from_time"   ></td>
            <td>To time</td>
            <td><input type="text" name ="to_time" ></td>            
        </tr>
        <tr>
            <td >&nbsp;</td>            
            <td><input type ="submit" name="search_genre_country" value="Search" ></td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
    
        </tr>
    </table>
    </td>
</table>
</form>

<?php
    $genreCountrys = $searchGenreCountryController->getSearchResult();
    print count($genreCountrys) . " combinations found";
    if (count($genreCountrys) > 0) {
?>

<table style="width: 100%">
    <tr>
        <td>Country name</td>
        <td>Genre name</td> 
        <td>Total number of books</td>
    </tr>    
	<?php
        foreach($genreCountrys as $genreCountry) {
 ?>
       <tr>
		<td><?php echo $genreCountry->getGenreName(); ?></td>
                <td><?php echo $genreCountry->getCountryName(); ?></td>
                <td><?php echo $genreCountry->getNumberAwards(); ?></td>
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