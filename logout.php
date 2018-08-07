<?php
//////////////////////////////////////////////////////
//
//		The PHP RPG Project
//
//	Version		:	1.0.0a
//	Author		:	The XPHPX Team!
//
//
//////////////////////////////////////////////////////

session_start();
session_destroy();
if(isset($_COOKIE['usr_logged']))
{
	setCookie("usr_logged", $_COOKIE['usr_logged'], time()-36000);
}
header("Location: login.php");
?>