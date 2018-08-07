<?php
$html['header'] = <<<html
<html>
<head>
<style>
<!--
body, td {
        font-family: Verdana;
        font-size: 10px;
}
a, a:link, a:visited, a:active {
        font-family: Verdana;
        font-size: 10px; color: #51708E;
        text-decoration:none;
}
a:hover {
        font-family: Verdana;
        font-size: 10px;
        color: #51708E;
        text-decoration: underline;
}
input,textarea   {
        font-family: Verdana;
        font-size: 10px;
}
-->
</style>
<title>PRP Editor</title>
</head>
<body bgcolor="FFFFFF">
html;

$html['footer'] = <<<html
</body>
</html>
html;

$html['login_form'] = <<<html
<form method="post" action="index.php">
<table border="0">
<tr><td>Password:</td><td><input type="password" name="password"></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Log In">
</table>
</form>
html;

$html['npc_form'] = <<<html
<center>Fill out this form to add a new NPC to the database.</center>
        <form action={self} method=post name=form1>
        <table border=0 width=90%>
        <tr><td><b>Character Information</b></td><td></td></tr>
        <tr><td>Name:</td><td><input type=text name=name></td></tr>
        <tr><td>Image:</td><td><input type=text name=image><br>(<a href="#" onClick="window.open('{self}&sel=image', 'select_image', 'height=250, width=300, location=no, status=no');">select image</a>)</td></tr>
        <tr><td>Services:</td><td><input type="checkbox" name="barter"> barter<input type="checkbox" name="heal"> healing</td></tr>
        <tr><td>Move Around:</td><td><input type="checkbox" name="move_around"></td></tr>

        <tr><td></td><td><input type="submit" name="submit" value="Step 2"></td></tr>
        </table></form>
html;

$html['npc_weapons'] = <<<html
       <center>Select the weapons this NPC should be able to sell.</center>
        <form action={self} method=post>
        {inputs}
        <table border=0 width=100%>
        <tr><td><b>Image</b></td><td><b>Name</b></td><td><b>Damage</b></td><td><b>Value</b></td><td><b>Check</b></td></tr>
        {wep_list}
        <tr><td></td><td><input type="submit" name="submit" value="Step 3"></td></tr>
        </table></form>
html;

$html['npc_items'] = <<<html
       <center>Select the weapons this NPC should be able to sell.</center>
        <form action={self} method=post>
        {inputs}
        <table border=0 width=100%>
        <tr><td><b>Image</b></td><td><b>Name</b></td><td><b>Effect Type/Effect/Cap</b></td><td><b>Value</b></td><td><b>Check</b></td></tr>
        {item_list}
        <tr><td></td><td><input type="submit" name="submit" value="Finish"></td></tr>
        </table></form>
html;

$html['npc_image'] = <<<html
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"><img name="pictures" src="{initialimage}"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel" onChange="var ImageNum = '../images/npc/' + form.sel.value; document.images.pictures.src=ImageNum + '.gif';">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Select Image" onClick="opener.form1.image.value=form.sel.value; window.close();"></td>
        </tr>
</table>
</form>
html;
/*
$html['npc_weapons'] = <<<html
<script>
var comma = '';
</script>
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Add Weapon" onClick="opener.form1.weapons.value += comma + form.sel.value; comma = ',';"></td>
        </tr>
</table>
</form>
html;

$html['npc_items'] = <<<html
<script>
var comma = '';
</script>
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Add Item" onClick="opener.form1.items.value += comma + form.sel.value; comma = ',';"></td>
        </tr>
</table>
</form>
html;
  */
$html['npc_added'] = 'The NPC has been successfully added!';

$html['terrain_form'] = <<<html
<center>Fill out the entire form to add a new object.</center>
        <form action="{self}" method="post" name="form1">
        <table border=0 width=80% align="center">
                <tr><td>Name:</td><td><input type=text name=name></td></tr>
                <tr><td valign="top">Image:</td><td><input type=text name=image><br><font size=1><a href="#" onClick="window.open('{self}&selimg=1', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a></td></tr>
                <tr><td>On Top:</td><td><input type=checkbox name=ontop></td></tr>
                <tr><td></td><td><input type="submit" value="Add Object" name="submit"></td></tr>
                </table>
                </form>
html;

$html['added_terrain'] = 'The object has been added. <script language="javascript">opener.location.reload();</script>';

$html['terrain_image'] = <<<html
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"><img name="pictures" src="{initialimage}"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel" onChange="var ImageNum = '../images/obj/' + form.sel.value; document.images.pictures.src=ImageNum;">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Select Image" onClick="opener.form1.image.value=form.sel.value; window.close();"></td>
        </tr>
</table>
</form>
html;
$html['cache_error'] = 'Error updating the object cache!';
$html['cache_updated'] = 'The object cache has been successfully updated.';

$html['change_sector'] = <<<html
Simply select a sector name/id and click the submit button to change the current working sector.
<form action="{self}" method="post">
<table border="0">
<tr><td>Select Sector:</td><td><select name="sector">{list}</select></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Change Sectors"></td></tr>
</table>
</form>
html;

$html['changed_sector'] = 'Your current working sector has been changed. You can now close this window. <script language="javascript">opener.location.reload();</script>';

$html['sectorprty_form'] = <<<html
<center>Make any changes necessary to this form then click the submit button to apply the changes.</center>
<form action="{self}" method="post" name=form1>
<table border="0">
<tr><td>Name:</td><td><input type="text" name="name" value="{name}" size="30"></td></tr>
<tr><td>Background:</td><td><input type="text" name="bg" value="{bg}"><br><a href="#" onClick="window.open('{self}&selimg=1', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a></td></tr>
<tr><td>Random Monsters:</td><td><input type="checkbox" name="monsters" {monsters}></td></tr>
<tr><td>Sleep:</td><td><input type="checkbox" name="sleep" {sleep}></td></tr>
<tr><td>Top Teleport:</td><td><select name="toptele">{top_tele}</select></td></tr>
<tr><td>Bottom Teleport:</td><td><select name="bottele">{bot_tele}</select></td></tr>
<tr><td>Left Teleport:</td><td><select name="lefttele">{left_tele}</select></td></tr>
<tr><td>Right Teleport:</td><td><select name="righttele">{right_tele}</select></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Apply Changes"></td></tr>
</table>
</form>
html;

$html['sectorprty_done'] = 'The sector has been successfully edited. You may now close this window. <script language="javascript">opener.location.reload();</script>';

$html['sector_image'] = <<<html
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"><img name="pictures" src="{initialimage}"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel" onChange="var ImageNum = '../images/background/' + form.sel.value + '.gif'; document.images.pictures.src=ImageNum;">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Select Image" onClick="opener.form1.bg.value=form.sel.value; window.close();"></td>
        </tr>
</table>
</form>
html;

$html['sector_new'] = <<<html
<center>Fill out this form to create a new sector.</center>
<form action="{self}" method="post" name=form1>
<table border="0">
<tr><td>Name:</td><td><input type="text" name="name" size="30"></td></tr>
<tr><td>Background:</td><td><input type="text" name="bg"><br><a href="#" onClick="window.open('{self}&selimg=1', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a></td></tr>
<tr><td>Random Monsters:</td><td><input type="checkbox" name="monsters"></td></tr>
<tr><td>Sleep:</td><td><input type="checkbox" name="sleep"></td></tr>
<tr><td>Top Teleport:</td><td><select name="toptele">{sector_list}</select></td></tr>
<tr><td>Bottom Teleport:</td><td><select name="bottele">{sector_list}</select></td></tr>
<tr><td>Left Teleport:</td><td><select name="lefttele">{sector_list}</select></td></tr>
<tr><td>Right Teleport:</td><td><select name="righttele">{sector_list}</select></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Add Sector"></td></tr>
</table>
</form>
html;

$html['newsector_done'] = 'Sector has been added successfully.';
$html['newsector_missing'] = 'Both the name and image fields MUST be filled out.';

$html['new_building'] = <<<html
Fill out this form to add a new building to your current location. Make sure you select an
image before selecing a door location.
<form action="{self}" method="post" name="form1">
<table border="0" cellpadding="6">
<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
<tr><td>Image:</td><td><input type="text" name="image"><br><a href="#" onClick="window.open('{self}&selimg=1', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a></td></tr>
<tr><td>Interior Sector:</td><td><select name="sector">{sector_list}</select></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Select Door Location"></td></tr>
</table>
</form>
html;

$html['building_image'] = <<<html
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"><img name="pictures" src="{initialimage}"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel" onChange="var ImageNum = '../images/buildings/' + form.sel.value; document.images.pictures.src=ImageNum;">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Select Image" onClick="opener.form1.image.value=form.sel.value; window.close();"></td>
        </tr>
</table>
</form>
html;

$html['new_building2'] = <<<html
Select where you want the door to be on the building.
<center>
<form action="{self}" method="post">
{inputs}
<table border="0" width="{width}" height="{height}" background="{bg}">
{inside}
</table>
<input type="submit" name="final" value="Add It">
</form>
</center>
html;

$html['building_added'] = 'Building has been added. <script language="javascript">opener.location.reload();</script>';

$html['dialogue_list'] = <<<html
<center>Click edit to edit the NPCs dialogue and give them new things to speak about.</center>
<br />
<table border="0" width="100%">
<tr><td><b>Name</b></td><td><b>Dialogue Status</b></td><td><b>Actions</b></td></tr>
{list}
</table>
html;

$html['dialogue_topics'] = <<<html
<center>Add or delete new topic or change the greeting. Click submit to make your changes.</center>
<br />
<form action="{self}&act=edit&npc={npc}&update=1" method="post">
<center><b>Greeting:</b></center><br />
<textarea name="greeting" rows=4 cols=70>{greeting}</textarea><br /><br />
<center><b>Topics:</b></center><br />
Title: <input type="text" name="title"> Text: <input type="text" name="text">
<table border="0" width="100%">
<tr><td><b>Title</b></td><td><b>Full Text</b></td><td><b>Actions</b></td></tr>
{list}
</table>
<br /><br />
<center><input type="submit" name="submit" value="Update"></center>
</form>
html;

$html['weapon_list'] = <<<html
<center>
<a href="{self}&act=add">Add New Weapon</a>
</center><br /><br />
<table border="0" width="100%">
<tr><td><b>Name</b></td><td><b>Damage</b></td><td><b>Value</b></td><td><b>Actions</b></td></tr>
{list}
</table>
html;

$html['weapon_add'] = <<<html
<center>Fill out this form to add a new weapon.</center><br /><br />
<form action="{self}&act=add" method="post" name="form1">
<table border="0" width="100%">
<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
<tr><td>Image:</td><td><input type="text" name="image"><br />(<a href="#" onClick="window.open('{self}&act=image', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a>)</td></tr>
<tr><td>Minimum Damage:</td><td><input type="text" name="min_damage" size="15"></td></tr>
<tr><td>Maximum Damage:</td><td><input type="text" name="max_damage" size="15"></td></tr>
<tr><td>Value:</td><td><input type="text" name="value" size="15"></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Add Weapon"></td></tr>
</table>
html;

$html['weapon_add_success'] = <<<html
<center>Weapon has been added successfully.</center>
<br /><a href="{self}">Back</a>
html;

$html['weapon_deleted'] = '<center>Weapon deleted</center><br /><a href="{self}">Back</a>';

$html['weapon_image'] = <<<html
<form action="" method="post">
<table width="75%" border="0" align="center">
        <tr>
                <td height="100" align="center"><img name="pictures" src="{initialimage}"></td>
        </tr>
        <tr>
                <td align="center"><select name="sel" onChange="var ImageNum = '../images/weapons/' + form.sel.value; document.images.pictures.src=ImageNum + '.gif';">{list}</select></td>
        </tr>
        <tr>
                <td align="center"><input type="button" name="addit" value="Select Image" onClick="opener.form1.image.value=form.sel.value; window.close();"></td>
        </tr>
</table>
</form>
html;

$html['weapon_edit'] = <<<html
<center>Fill out this form to edit a weapon.<br /><a href="{self}">Back</a></center><br /><br />
<form action="{self}&act=edit&wid={wid}" method="post" name="form1">
<table border="0" width="100%">
<tr><td>Name:</td><td><input type="text" name="name" value="{name}"></td></tr>
<tr><td>Image:</td><td><input type="text" name="image" value="{image}"><br />(<a href="#" onClick="window.open('{self}&act=image', 'selImage', 'directories=no,height=250,width=300,left=100,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')">select image</a>)</td></tr>
<tr><td>Minimum Damage:</td><td><input type="text" name="min_damage" size="15" value="{mindmg}"></td></tr>
<tr><td>Maximum Damage:</td><td><input type="text" name="max_damage" size="15" value="{maxdmg}"></td></tr>
<tr><td>Value:</td><td><input type="text" name="value" size="15" value="{value}"></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Edit Weapon"></td></tr>
</table>
html;

$html['weapon_edited'] = '<center>Weapon edited.</center><br /><a href="{self}">Back</a>';
?>
