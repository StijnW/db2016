<?php
	
$title = "Update chapters of books";

require("template/top.tpl.php");
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
            <td>Genre</td>            
            <td colspan="3" style="width: 85%">
                <select style="width: 50%" name="country">
                    <option value="">--------Book genres ---------- </option>                    
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


<table style="width: 100%">
    <tr>
        <td>Book name</td>
        <td>Chapters</td>
        <td>Add chapters</td>       
    </tr>
    <tr>
        <td><a href="update_book_chapters.php?book_uri=http://dbpedia.org/resource/(un)arranged_marriage">(un)arranged marriage</a></td>
        <td><a href="update_book_chapters.php?book_uri=http://dbpedia.org/resource/(un)arranged_marriage">3</a></td>
        <td><a href="add_book_chapters.php?book_uri=http://dbpedia.org/resource/(un)arranged_marriage">Add chapter</a></td>
    </tr>
    
    
</table>

<?php
	require("template/bottom.tpl.php");
?>