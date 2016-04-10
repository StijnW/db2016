<?php
	
$title = "Search number awards per genre per country";

require("template/top.tpl.php");
require_once("gb/controller/SearchGenreCountryController.php");
require_once("gb/domain/GenreCountry.php");
require_once("gb/mapper/GenreCountryMapper.php");

$searchGenreCountryController = new gb\controller\SearchGenreCountryController();
$searchGenreCountryController->process();

$GenreCountryMapper = new gb\mapper\GenreCountryMapper();
$allGenreCountries = $GenreCountryMapper->findAll();
 
?>   

<tr>
    <td colspan="4">
    <table style="width: 100%">
        <tr>
            <td>Start Period</td>
            <td><input type="text" name ="start_date"   ></td>
            <td>End Period</td>
            <td><input type="text" name ="end_date" ></td>            
        </tr>
		<tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td><input type ="submit" name="search_genre_country" value="Search" ></td>
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
        <td>Genre Name</td>
        <td>Country Name</td>
        <td>Number Awards</td>
    </tr>   

<?php
        foreach($genreCountrys as $genreCountry) {
 ?>
       <tr>
		<td><?php echo $genreCountry->getGenreName(); ?></td>
                <td><?php echo $GenreCountry->getCountryName(); ?></td>
                <td><?php echo $GenreCountry->getNumberAwards(); ?></td>
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