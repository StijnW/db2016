<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");


class WinAwardController extends PageController {
    function process() {
        if (isset($_POST["search"])) {
            print "Please provide some piece of code here to search books that win awards!";
        }
    }
}

?>