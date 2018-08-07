<?php
if(isset($_GET['selimg']))
{
	// get the current image
	$sql = "SELECT bg FROM sectors 
			WHERE id = '$_SESSION[ed_sector]'";

	$result = $db->db_query($sql);
	$sector = $db->db_fetch_array($result);

	// get a list of images
	$list = "<option value=$sector[bg] SELECTED>$sector[bg] (current)</option>";
	$dh = opendir('../images/background/');
	while($file = readdir($dh))
	{
		if($file == '.' || $file == '..')
		{
			continue;
		}
		$fileNoExt = explode('.', $file);
		$fileNoExt = $fileNoExt[0];

		$list .= "<option value=\"$fileNoExt\">$file</option>\n";
		$lastFile = $file;
	}
	$page = makepage('sector_image', '', 0);
	$page = str_replace('{list}', $list, $page);
	$page = str_replace('{initialimage}', "../images/background/$sector[bg].gif", $page);


	echo $page;
	exit;
}

if(!isset($_POST['submit']))
{
	// declare variables
	$sector_list = '<option value="">n/a</option>';
	$list_temp = '';
	$list_temp2 = '';

	// put the sector id into a variable
	$secid = $_SESSION['ed_sector'];

	// get the information for this sector
	$sql = "SELECT * FROM sectors
			WHERE id = '$secid'";

	$result = $db->db_query($sql);
	$sector = $db->db_fetch_array($result);

	// generate variables for the checkboxes in the form
	$sleep = '';
	if($sector['sleep'] == 1)
	{
		$sleep = 'CHECKED';
	}

	$monsters = '';
	if($sector['monsters'] == 1)
	{
		$monsters = 'CHECKED';
	}

	// now lets get the lists/figure out what sectors are connected to this one
	$sql = "SELECT * FROM sectors";
	
	$result = $db->db_query($sql);
	while($row = $db->db_fetch_array($result))
	{
		$sector_list .= "<option value=$row[id]>$row[name]</option>";
	}

	// this loop will get a list of the sectors for displaying to the user, and it will select the sector
	// that is currently selected in the database. We'll use a loop for simplicities sake since the code is basically the same
	// every time.
	for($i = 0; $i < 4; $i++)
	{
		// this will determine which position of the loop we're in
		if($i == 0)
		{
			$which = 'top_tele';
		}
		elseif($i == 1)
		{
			$which = 'bot_tele';
		}
		elseif($i == 2)
		{
			$which = 'left_tele';
		}
		elseif($i == 3)
		{
			$which = 'right_tele';
		}


		// now lets actually make a list
		$sql = "SELECT * FROM sectors
				WHERE id = '$sector[$which]'";
		
		$result = $db->db_query($sql);

		$num = $db->db_num_rows($result);
		if($num == 0)
		{
			// it doesnt go anywhere so we'll just display the default list
			$lists[$which] = $sector_list;
			continue;
		}

		while($row = $db->db_fetch_array($result))
		{
			$list_temp = "<option value=$row[id]>$row[name]</option>";
			$list_temp2 = "<option value=$row[id] SELECTED>$row[name]</option>";
	
			// add it onto the list
			$lists[$which] = str_replace($list_temp, $list_temp2, $sector_list);
		}
	}

	// build the actual page
	$page = makepage('sectorprty_form', '', 0);
	$page = str_replace('{name}', $sector['name'], $page);
	$page = str_replace('{bg}', $sector['bg'], $page);
	$page = str_replace('{monsters}', $monsters, $page);
	$page = str_replace('{sleep}', $sleep, $page);
	$page = str_replace('{top_tele}', $lists['top_tele'], $page);
	$page = str_replace('{bot_tele}', $lists['bot_tele'], $page);
	$page = str_replace('{left_tele}', $lists['left_tele'], $page);
	$page = str_replace('{right_tele}', $lists['right_tele'], $page);

	echo $page;
}
else
{
	// declare variables
	$monsters = 0;
	$sleep = 0;

	if($_POST['monsters'] == 'on')
	{
		$monsters = 1;
	}

	if($_POST['sleep'] == 'on')
	{
		$sleep = 1;
	}

	$sql = "UPDATE sectors 
			SET name = '$_POST[name]', bg = '$_POST[bg]', monsters = '$monsters', sleep = '$sleep', top_tele = '$_POST[toptele]', bot_tele = '$_POST[bottele]', left_tele = '$_POST[lefttele]', right_tele = '$_POST[righttele]'
			WHERE id = '$_SESSION[ed_sector]'";

	$result = $db->db_query($sql);

	makepage('sectorprty_done');
}
?>