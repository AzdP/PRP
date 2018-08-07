<?php
//
// This file handles all requests for modules that are made through
// the links on the main page
//

require('startup.php');

// make sure that a module is set and that it is a valid module file
if(!isset($_GET['mid']) || !file_exists("scripts/$_GET[mid].php"))
{
        die('Critical error');
}

// logged in?
if(!session_is_registered($sessid))
{
	die('hacking attempt');
}

// make some variables that can be used in the subscripts
$src_file = 'module.php?mid=' . $_GET['mid'];
$cur_x = $_SESSION['ed_x'];
$cur_y = $_SESSION['ed_y'];
$cur_sector = $_SESSION['ed_sector'];


// run the module
require("scripts/$_GET[mid].php");
?>

