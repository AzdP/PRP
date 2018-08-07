<?php
require('startup.php');

// handle login
if(!session_is_registered($sessid))
{
        if(!isset($_POST['password']))
        {
                makePage('login_form');
                exit;
        }
        else
        {
                if($_POST['password'] == $prefs['passwd'])
                {
                        session_register($sessid);

                        $_SESSION['ed_moveby'] = 50;

                        header('Location: index.php');
                        exit;
                }

                makePage('login_form', '<b>Login failed!</b><br>');
                exit;
        }
}

//
// Handle whether or not to show clipping
//
if(isset($_GET['clipping']))
{
        // change the clipping session
        if($_SESSION['ed_clipping'] == 0)
        {
                $_SESSION['ed_clipping'] = 1;
        }
        else
        {
                $_SESSION['ed_clipping'] = 0;
        }

        // refresh
        header("Location: index.php");
        exit;
}

//
// Update X and Y values based on location
//
if(isset($_GET['x']))
{
        $_SESSION['ed_x'] = $_GET['x'];
        $cur_x = $_GET['x'];
}
else
{
        $cur_x = $_SESSION['ed_x'];
}

if(isset($_GET['y']))
{
        $_SESSION['ed_y'] = $_GET['y'];
        $cur_y = $_GET['y'];
}
else
{
        $cur_y = $_SESSION['ed_y'];
}

//
// Clipping Management
//
if(isset($_POST['clip']))
{
        // they want to remove or add clipping

        // check to see if it exists here
        $sql = "SELECT * FROM clipping
                WHERE x = '$cur_x' AND y = '$cur_y' AND sector_id = '$_SESSION[ed_sector]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num > 0)
        {
                // they want to remove it
                $sql = "DELETE FROM clipping
                        WHERE x = '$cur_x' AND y = '$cur_y' AND sector_id = '$_SESSION[ed_sector]'";

                $result = $db->db_query($sql);

                $alerts = add_alert('clipping removed');
        }
        else
        {
                // they want to add it
                $sql = "INSERT INTO clipping
                        VALUES ('', '$_SESSION[ed_sector]', '$cur_x', '$cur_y')";

                $result = $db->db_query($sql);

                $alerts = add_alert('clipping added');
        }
}

// build the current world
$world = $editor->drawsector();

//
// Handle the selecting of objects
//
$grabObj['disabled'] = 'DISABLED';
$deleteObj['disabled'] = 'DISABLED';
$grabObj['button'] = 'Grab Object';
$objSelected = null;

// terrain selections
if(isset($world['objIndex'][$cur_x . ':' . $cur_y]))
{
        $grabObj['disabled'] = '';

        // yes on top of an object
        $onTopOf = $world['objIndex'][$cur_x . ':' . $cur_y];

        $onTopType = 'object';
}

// building selections
if(isset($world['buildIndex'][$cur_x . ':' . $cur_y]))
{
        $grabObj['disabled'] = '';

        $onTopOf = $world['buildIndex'][$cur_x . ':' . $cur_y];

        $onTopType = 'building';
}

// npc selections
if(isset($world['npcIndex'][$cur_x . ':' . $cur_y]))
{
	$grabObj['disabled'] = '';

         $onTopOf = $world['npcIndex'][$cur_x . ':' . $cur_y];

         $onTopType = 'npc';
}

if(isset($_POST['grab']) && $_SESSION['selected'] == 0)
{
        // user wants to grab the object
        $_SESSION['selected'] = $onTopOf;
        $_SESSION['select_type'] = $onTopType;

        $objSelected = $onTopOf;

        $alerts = add_alert('object selected');
}

if(isset($_POST['grab']) && $objSelected == null)
{
        // user wants to drop the object
        $_SESSION['selected'] = null;
        $_SESSION['select_type'] = null;
        $objSelected = null;

        $alerts = add_alert('object dropped');
}

// update x and y values for object if its selected
if($objSelected != null || $_SESSION['selected'] != null)
{
        $objID = $_SESSION['selected'];

        if($_SESSION['select_type'] == 'object')
        {
                $sql = "UPDATE terrain
                        SET x = '$cur_x', y = '$cur_y'
                        WHERE id = '$objID'";
        }
        elseif($_SESSION['select_type'] == 'building')
        {
                // update doors
                $sql = "SELECT * FROM buildings
                        WHERE id = '$objID'";

                $result = $db->db_query($sql);
                $row = $db->db_fetch_array($result);

                $door_x = abs($row['x'] - $cur_x) + $row['door_x'];
                $door_y = abs($row['y'] - $cur_y) + $row['door_y'];

                $sql = "UPDATE buildings
                        SET x = '$cur_x', y = '$cur_y', door_x = '$door_x', door_y = '$door_y'
                        WHERE id = '$objID'";
        }
        elseif($_SESSION['select_type'] == 'npc')
        {
                $sql = "UPDATE npc SET
                	       x = '$cur_x', y = '$cur_y'
                	       WHERE id = '$objID'";
        }

        $result = $db->db_query($sql);

        // redraw the sector
        $world = $editor->drawsector();
}

// are we grabbed onto something?
if($_SESSION['selected'] != 0)
{
        $grabObj['disabled'] = '';
        $grabObj['button'] = 'Drop Object';

        // activate the delete button
        $deleteObj['disabled'] = '';
}

//
// Delete objects
//
if(isset($_POST['delete']))
{
        if($_SESSION['select_type'] == 'object')
        {
                $table = 'terrain';
        }
        elseif($_SESSION['select_type'] == 'building')
        {
                $table = 'buildings';
        }
        elseif($_SESSION['select_type'] == 'npc')
        {
                 $table = 'npc';
        }

        // remove the object
        $sql = "DELETE FROM $table
                WHERE id = '$_SESSION[selected]'";

        $result = $db->db_query($sql);

        $alerts = add_alert('object deleted');

        // also drop it and disable the buttons
        $_SESSION['selected'] = null;
        $objSelected = null;
        $grabObj['disabled'] = 'DISABLED';
        $grabObj['button'] = 'Grab Object';
        $deleteObj['disabled'] = 'DISABLED';

        // redraw the sector
        $world = $editor->drawsector();
}

//
// Links to other sectors
//
$sql = "SELECT * FROM sectors
        WHERE id = '$_SESSION[ed_sector]'";

$result = $db->db_query($sql);
$sector = $db->db_fetch_array($result);

//
// Arrows for easier navigation
//
if($sector['top_tele'] != 0)
{
        // they can move up
        $world['html'] .= "<div style=\"LEFT: " . (200 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (20 + $yoffset) . "px; Z-index: 101;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$sector[top_tele]&close=1', 'change_sector', 'directories=no,height=0,width=0,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/arrow_up.gif border=0></a></div>";
}

if($sector['left_tele'] != 0)
{
        // they can move up
        $world['html'] .= "<div style=\"LEFT: " . (20 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (200 + $yoffset) . "px; Z-index: 101;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$sector[left_tele]&close=1', 'change_sector', 'directories=no,height=0,width=0,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/arrow_left.gif border=0></a></div>";
}

if($sector['right_tele'] != 0)
{
        // they can move up
        $world['html'] .= "<div style=\"LEFT: " . (350 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (200 + $yoffset) . "px; Z-index: 101;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$sector[right_tele]&close=1', 'change_sector', 'directories=no,height=0,width=0,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/arrow_right.gif border=0></a></div>";
}

if($sector['bot_tele'] != 0)
{
        // they can move up
        $world['html'] .= "<div style=\"LEFT: " . (200 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (350 + $yoffset) . "px; Z-index: 101;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$sector[bot_tele]&close=1', 'change_sector', 'directories=no,height=0,width=0,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/arrow_down.gif border=0></div>";
}

// We'll want to make an arrow if they're in a building...
$sql = "SELECT * FROM buildings
        WHERE interior = '$_SESSION[ed_sector]'";

$result = $db->db_query($sql);
$num = $db->db_num_rows($result);

if($num > 0)
{
        // its an interior
        $interior = $db->db_fetch_array($result);

        // draw a down arrow to exit
        $world['html'] .= "<div style=\"LEFT: " . (200 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (350 + $yoffset) . "px; Z-index: 101;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$interior[sector_id]&close=1', 'change_sector', 'directories=no,height=0,width=0,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/arrow_down.gif border=0></div>";
}

// include the main editor template which is located in another file
$template = file_get_contents('includes/template.inc.php');

// see how many pxls to move
$moveby = $_SESSION['ed_moveby'];
if(isset($_POST['pixs_move']))
{
        // update the session
        $_SESSION['ed_moveby'] = $_POST['pixs_move'];
        $moveby = $_POST['pixs_move'];
}

// replace some template variables
$template = str_replace('{main}', '<style>' . $world['div_style'] . '</style>' . $world['html'], $template);
$template = str_replace('{u_y}', $cur_y, $template);
$template = str_replace('{u_x}', $cur_x, $template);
$template = str_replace('{grab_disabled}', $grabObj['disabled'], $template);
$template = str_replace('{grab_button}', $grabObj['button'], $template);
$template = str_replace('{del_disabled}', $deleteObj['disabled'], $template);
$template = str_replace('{system_msg}', $alerts, $template);
$template = str_replace('{pixel_moves}', $moveby, $template);

// make the move buttons work
$move_left = $cur_x - $moveby;
$move_right = $cur_x + $moveby;
$move_up = $cur_y - $moveby;
$move_down = $cur_y + $moveby;

$template = str_replace('{move_left}', $move_left, $template);
$template = str_replace('{move_right}', $move_right, $template);
$template = str_replace('{move_down}', $move_down, $template);
$template = str_replace('{move_up}', $move_up, $template);

echo $template;
?>
