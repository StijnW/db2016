<?php
// Onderstaande lijnen zijn instructies voor de web-browser over hoe ze een pagina moet
// implementeren.
session_start(); 		// -- session_start() op deze plek is niet erg netjes, maar voldoet voor dit practicum
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl-BE" lang="nl-BE">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php // s ?>
	<title><?php print $title;?></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div class="navigation">
<h2 class="indexTitle">Index</h2>
<ul>
	<li><a href="index.php">Home</a></li>
        <li><a href="search_writers.php">Search writers</a></li>
        <li><a href="search_books.php">Search books</a></li>
		<li><a href="list_book_chapters.php">Update chapters</a></li>
        <li><a href="list_spouses.php">Writer spouses</a></li>
        <li><a href="list_books_win_awards.php">Books & awards</a></li>
		<li><a href="find_similar_books_select_1.php">Find similar books</a></li>
        
        
	
</ul>
</div>
<div class="main">
<h2 class="contentTitle"><?php print $title;?></h2>