<?php
//////////////////////////////////////////////////////
//
//                The PHP RPG Project
//
//        Version         :        1.0.0a
//        Author          :        The XPHPX Team!
//
//
//////////////////////////////////////////////////////
require("includes/startup.php");

// setup some default variables
$music = '';
$ask_pvp_battle = false;
$pvp_id = '';
$opp_name = '';

// see if the user is turning chat off or on
if(isset($_GET['chat']))
{
        if($_GET['chat'] == 0)
        {
                $_SESSION['chat'] = FALSE;
        }
        else
        {
                $_SESSION['chat'] = TRUE;
        }
}

// check if the random battle session is set
if(session_is_registered('randbattle') && $_SESSION['randbattle'] == TRUE)
{
        // shouldnt be set
        $_SESSION['randbattle'] = FALSE;
}

// lets check to see if the user was in a fight and just left
if($_SESSION['in_fight'] == 1)
{
        // send them back for trying to cheat
        header('Location: fight.php?monster=' . $_SESSION['pos_id']);
        exit;
}

// Check to see if this user is being challenged by somebody to a PVP battle...
$pvp = $player->checkPVP();
$pvp_info = $pvp['pvp_info'];
$ask_pvp_battle = $pvp['ask'];

if(isset($_GET['x']) && isset($_GET['y']))
{
        // Random Battles
        // A sub-routine for random battles
        //
        // todo: do something like if($u_x != $_GET['x']) to make it so if the user has not moved nothing happens
        // this is so they can refresh as many times as they want
        $sql = "SELECT * FROM sectors
                        WHERE id = '$user[7]'";

        $result = $db->db_query($sql);
        $sector = $db->db_fetch_array($result);

        if($sector[3] == 1)
        {
                // yes there are random battles in this sector!
                //----------------

                // first we need to gen a random number
                $rand = rand(0, 100);

                // if its above 85 then there is a random battle
                if($rand >= 85)
                {
                        // now what monster are we going to battle?!
                        $sql = "SELECT id FROM monsters
                                WHERE hp = '-1' AND norand = '0'
                                ORDER BY RAND() LIMIT 1";

                        $result = $db->db_query($sql);
                        $monster = $db->db_fetch_array($result);

                        // Set a session for fraud protection
                        $_SESSION['valid_monsters'] = $monster['id'];
                        $_SESSION['randbattle'] = TRUE;

                        header("Location: fight.php?monster=$monster[id]");
                        exit;
                }
        }

        // lets make sure they're not cheating by changing the GET vars
        $difference1 = abs($user[8] - $_GET['x']);
        $difference2 = abs($user[9] - $_GET['y']);

        if(($difference1 != 50 && $difference1 != 0) || ($difference2 != 50 && $difference2 != 0))
        {
                        // redirect to previous position
                        header("Location: index.php?x=$user[8]&y=$user[9]");
                        exit;
        }

        // Transportation? (from buildings)
        $sql = "SELECT * FROM buildings
                WHERE door_x = '$_GET[x]' AND door_y = '$_GET[y]' AND sector_id = '$user[7]'
                LIMIT 1";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num > 0)
        {
                $row = $db->db_fetch_array($result);

                $sql = "UPDATE players
                        SET sector = '$row[6]', y = '350'
                        WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                // refresh the page, but change the y
                header("Location: index.php?x=$user[8]&y=350");
                exit;
        }

        // Clipping
        $sql = "SELECT * FROM clipping
                WHERE sector_id = '$user[7]' AND x = '$_GET[x]' AND y = '$_GET[y]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num > 0)
        {
                //
                // transport them back to where they were before they
                // made the move (the db has yet to be updated so we'll
                // get the previous position from there)
                //
                $u_x = $user['x'];
                $u_y = $user['y'];
        }
        else
        {
                $changePos = $player->changePos($_GET['x'], $_GET['y']);

                $u_x = $_GET['x'];
                $u_y = $_GET['y'];
        }
}
else
{
        // they're in the same spot so we dont have to run anything...
        $u_x = $user['x'];
        $u_y = $user['y'];
}

// Sector movement to the left and right
if($u_x > 350)
{
        if($sector['right_tele'] != 0)
        {
                $sql = "UPDATE players
                        SET sector = '$sector[8]', x = '0', y = '$user[9]'
                        WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                header("Location: index.php?x=0&y=$u_y");
                exit;
        }
        else
        {
                $sql = "UPDATE players
                        SET x = '350'
                        WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                $u_x = 350;
                header("Location: index.php?x=$u_x&y=$u_y");
                exit;
        }
}

if($u_x < 0)
{
        if($sector['left_tele'] != 0)
        {
                $sql = "UPDATE players
                                SET x = '350', sector = '$sector[7]'
                                WHERE name = '$user[1]'";

                $result = $db->db_query($sql);
                header("Location: index.php?x=350&y=$u_y");
                exit;
        }
        else
        {
                $sql = "UPDATE players
                        SET x = '0'
                        WHERE name = '$user[1]'";

                $result = $db->db_query($sql);

                $u_x = 0;
                header("Location: index.php?x=$u_x&y=$u_y");
                exit;
        }
}

// Sector movement up and down
if($u_y > 350)
{
        // real Y value
        if(isset($_GET['y']))
        {
                $r_y = $_GET['y'];
        }
        else
        {
                $r_y = $u_y;
        }

        if($r_y > 350)
        {
                $sql = "SELECT * FROM buildings
                                WHERE interior = '$sector[0]'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);
                if($num > 0)
                {
                        // this is a building and the user is trying to leave!!
                        $row = $db->db_fetch_array($result);

                        $new_x = $row[7];
                        $new_y = $row[8] + 50;

                        $sql = "UPDATE players
                                        SET sector = '$row[2]', x = '$new_x', y = '$new_y'
                                        WHERE name = '$user[name]'";

                        $result = $db->db_query($sql);

                        header("Location: index.php?x=$row[7]&y=$new_y");
                        exit;
                }
                elseif($sector[6] != 0)
                {
                        $sql = "UPDATE players
                                        SET y = '0', sector = '$sector[bot_tele]'
                                        WHERE name = '$user[name]'";

                        $result = $db->db_query($sql);

                        header("Location: index.php?x=$u_x&y=0");
                        exit;
                }

                header("Location: index.php?x=$u_x&y=350");
                exit;
        }

        $u_y = 0;
}

if($u_y < 0)
{
        if($sector[5] != 0)
        {
                $sql = "UPDATE players
                                SET y = '350', sector = '$sector[5]'
                                WHERE name = '$user[1]'";

                $result = $db->db_query($sql);

                $u_y = 350;
                header("Location: index.php?x=$u_x&y=350");
                exit;
        }
        else
        {
                $sql = "UPDATE players
                                SET y = '0'
                                WHERE name = '$user[1]'";

                $result = $db->db_query($sql);
                $u_y = 350;
                header("Location: index.php?x=$u_x&y=0");
                exit;
        }
}

if($u_y < 0)
{
        $sql = "UPDATE players
                SET y = '0'
                WHERE id = '$user[id]'";

        $result = $db->db_query($sql);
        $u_y = 0;

        header("Location: index.php?x=$u_x&y=0");
        exit;
}

// generate navigation links
$move_left = 'index.php?x=' . ($u_x - 50) . '&y=' . $u_y;
$move_right = 'index.php?x=' . ($u_x + 50) . '&y=' . $u_y;
$move_up = 'index.php?x=' . $u_x . '&y=' . ($u_y - 50);
$move_down = 'index.php?x=' . $u_x . '&y=' . ($u_y + 50);

// setup sector ID
$sid = $user['sector'];

// now we gotta grab the sector information
$sql = "SELECT * FROM sectors
        WHERE id = '$sid'";

$result = $db->db_query($sql);
$sector = $db->db_fetch_array($result);

// generate the actual screen
$output = drawsector();

// generate graphs
$hp_graph = makegraph($user[13], $user[14], 'HP:&nbsp; ', 'red');
$mp_graph = makegraph($user[15], $user[16], 'MP:&nbsp; ', 'blue');

// see if chat is enabled
$chatFrame = '';
if($_SESSION['chat'] == TRUE || (isset($_GET['chat']) && $_GET['chat'] == 1))
{
        $chatFrame = '<iframe width="100%" height="161" src="chat.php" frameborder="0" scrolling="'.$scroll_chats.'">Please enable Iframes</iframe>';
}

// do we need a + or - for the chat box?
if($_SESSION['chat'] == TRUE)
{
        $chatToggle = $lang['chat'] . ' [<a href="index.php?chat=0">-</a>]';
}
else
{
        $chatToggle = $lang['chat'] . ' [<a href="index.php?chat=1">+</a>]';
}

// check to see if the fight button should be active
if($output['fight'] != '')
{
        $fightButton = '<a href="fight.php?monster='.$output['fight'].'"><img src="templates/'.$config['template'].'/images/action_fight2.gif" alt="Fight with a nearby monster" border="0"></a>';
}
else
{
        $fightButton = '<img src="templates/'.$config['template'].'/images/action_fight.gif" alt="Fight with a nearby monster" border="0">';
}

$html = '';

//
// Now lets put some arrows on to let the player know that they can change sectors
//
if($sector['top_tele'] != 0)
{
        // they can move up
        $html .= "<div style=\"LEFT: " . (200 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (20 + $yoffset) . "px; Z-index: 101;\"><img src=images/arrow_up.gif></div>";
}

if($sector['left_tele'] != 0)
{
        // they can move up
        $html .= "<div style=\"LEFT: " . (20 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (200 + $yoffset) . "px; Z-index: 101;\"><img src=images/arrow_left.gif></div>";
}

if($sector['right_tele'] != 0)
{
        // they can move up
        $html .= "<div style=\"LEFT: " . (350 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (200 + $yoffset) . "px; Z-index: 101;\"><img src=images/arrow_right.gif></div>";
}

if($sector['bot_tele'] != 0)
{
        // they can move up
        $html .= "<div style=\"LEFT: " . (200 + $xoffset) . "px; VISIBILITY: visible; POSITION: absolute; TOP: " . (350 + $yoffset) . "px; Z-index: 101;\"><img src=images/arrow_down.gif></div>";
}

// index messages
if($index_message == '')
{
        $message = 'n/a';
}
else
{
        $message = $index_message;
}

// Put the world together
$html .= file_get_contents("cache/$user[7]html.txt");
$html .= $output['html'];

$script_header = <<<html
<script language="javascript" src="includes/javascript.js"></script>
<script type="text/javascript">
<!--
function getkey(e)
{
if (window.event)
   return window.event.keyCode;
else if (e)
   return e.which;
else
   return null;
}

function redir(key)
{
        var rkey = getkey(key);

        if(rkey == 119)
        {
                document.location.href="$move_up";
        }

        if(rkey == 115)
        {
                document.location.href="$move_down";
        }

        if(rkey == 97)
        {
                document.location.href="$move_left";
        }

        if(rkey == 100)
        {
                document.location.href="$move_right";
        }
}
//-->
</script>
<div id="dwindow" style="position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none;z-index:1000;" onMousedown="initializedrag(event)" onMouseup="stopdrag()" onSelectStart="return false">
<div align="right" style="background-color:navy"><img src="images/max.gif" id="maxname" onClick="maximize()"><img src="images/close.gif" onClick="closeit()"></div>
<div id="dwindowcontent" style="height:100%">
<iframe id="cframe" src="" width=100% height=100%></iframe>
</div>
</div>
html;

// generate a code so that the index messages can be displayed in the top left of the game window
$message_top_left = <<<html
<div style="position:absolute;left:$xoffset px;top:$yoffset px;visibility: visible;z-index:999;">
$index_message
</div>
html;

// list of users online
$online_list = online_list();

// see if they should be accepting a battle or not
if($ask_pvp_battle == false)
{
        // nope, just a normal page
        $output = $html;
}
else
{
        // yup, the ask page!

        // get opponent's name and set the PVP id
        $sql = "SELECT name FROM players
                WHERE id = '$pvp_info[challenger]'";

        $result = $db->db_query($sql);
        $opp = $db->db_fetch_array($result);

        // put them into variables
        $opp_name = $opp['name'];
        $pvp_id = $pvp_info['id'];

        $output = 'pvp_ask.tpl';
}

$page = new Template();

$page->set_files(array(
'body' => $output));

$page->assign_vars(array(
'page_script_header' => $script_header,
'fight_button' => $fightButton,
'chat_toggle' => $chatToggle,
'chat_frame' => $chatFrame,
'user_name' => $user['name'],
'user_level' => $user['level'],
'user_class' => $user['class'],
'user_exp' => $user['exp'],
'hp_graph' => $hp_graph,
'mp_graph' => $mp_graph,
'user_gold' => $user['gold'],
'music_link' => $sector['music'],
'index_message' => $index_message,
'index_div' => $message_top_left,
'online_list' => $online_list,
'pvp_id' => $pvp_id,
'opp_name' => $opp_name,
'move_up' => $move_up,
'move_down' => $move_down,
'move_right' => $move_right,
'move_left' => $move_left,
'move_refresh' => 'index.php'));

$page->ppage();

// debug information
if($debug == 1)
{
        attach_debug();
}
?>