<?php
//
//	Update cache script
//	-------------------------
//	This script updates the object cache
//	of the game.
//
$cache = update_cache();

if(!$cache)
{
	makepage('cache_error');
}

makepage('cache_updated');
?>