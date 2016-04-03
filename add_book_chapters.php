<?php

require_once("gb/controller/BookController.php");
$bookController = new gb\controller\BookController();
$bookController->process();

$title = "book_uri =" . $bookController->getSelectedBookUri();
require("template/top.tpl.php");
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="2">
    <table style="width: 100%">        
        <tr>
            <td>Chapter</td>            
            <td >
                <input type="text" name="chapter_number">
            </td>          
        </tr>        
        <tr>
            <td>Text:</td>
            <td><textarea name="new_text" cols="60" rows="6"></textarea></td>
        </tr>
        <tr>
            <td >&nbsp;</td>            
            <td><input type ="submit" name="add_chapter" value="Add chapter" ></td>
        </tr>
    </table>
    </td>
</table>
</form>



<?php
	require("template/bottom.tpl.php");
?>