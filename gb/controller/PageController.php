<?php
namespace gb\controller;

//require_once("gb/controller/Request.php");

abstract class PageController {
    abstract function process();

    function forward( $resource ) {
        include( $resource );
        exit( 0 );
    }

    function getRequest() {
        return "to be implemented";
    }
}    
?>