<?php
//
//	Make object script
//	------------------------
//	This allows the user to add a new
//	terrain object to the game.
//

if(isset($_GET['selimg']))
{
	// get a list of images
	$list = '';
	$dh = opendir('../images/obj/');
	while($file = readdir($dh))
	{
		if($file == '.' || $file == '..')
		{
			continue;
		}

		$list .= "<option value=\"$file\">$file</option>\n";
		$lastFile = $file;
	}
	$page = makepage('terrain_image', '', 0);
	$page = str_replace('{list}', $list, $page);
	$page = str_replace('{initialimage}', "../images/obj/$lastFile", $page);


	echo $page;
	exit;
}
	

if(!isset($_POST['submit']))
{
	// draw the form
	makepage('terrain_form');
}
else
{
	// is the image selected to be on top of everything else?
	$ontop = 0;
	if($_POST['ontop'] == 'on')
	{
		$ontop = 1;
	}

	// insert it into the db
	$sql = "INSERT INTO terrain
			(id,sector_id,name,image,ontop,x,y)
			VALUES ('', '$cur_sector', '$_POST[name]', '$_POST[image]', '$ontop', '$cur_x', '$cur_y')";

	$result = $db->db_query($sql);

	makepage('added_terrain');
}
?>