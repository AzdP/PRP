<?php
if(isset($_GET['selimg']))
{
	// get a list of images
	$list = "<option value=$sector[bg] SELECTED>$sector[bg].gif</option>";
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

	// now lets get the lists/figure out what sectors are connected to this one
	$sql = "SELECT * FROM sectors";
	
	$result = $db->db_query($sql);
	while($row = $db->db_fetch_array($result))
	{
		$sector_list .= "<option value=$row[id]>$row[name]</option>";
	}

	// build the actual page
	$page = makepage('sector_new', '', 0);
	$page = str_replace('{sector_list}', $sector_list, $page);

	echo $page;
}
else
{
	// declare variables
	$monsters = 0;
	$sleep = 0;

	if(!$_POST[name] || !$_POST[bg])
	{
		makepage('newsector_missing');
		exit;
	}

	if($_POST['monsters'] == 'on')
	{
		$monsters = 1;
	}

	if($_POST['sleep'] == 'on')
	{
		$sleep = 1;
	}

	$sql = "INSERT INTO sectors 
			VALUES ('', '$_POST[name]', '$_POST[bg]', '$monsters', '$sleep', '$_POST[toptele]', '$_POST[bottele]', '$_POST[lefttele]', '$_POST[righttele]', '')";

	$result = $db->db_query($sql);

	makepage('newsector_done');
}
?>