<?php
//////////////////////////////////////////////////////
//
//                The PHP RPG Project
//
//        Version                :        1.0.0a
//        Author                :        The XPHPX Team!
//
//
//////////////////////////////////////////////////////
require('includes/startup.php');

$user_list = '';

// current page of the list
if(isset($_GET['cur']) && trim($_GET['cur']) != '')
{
        $current = $_GET['cur'];
}
else
{
        $current = 0;
}

// per page
if(isset($_GET['perpg']) && trim($_GET['perpg']) != '')
{
        $perpage = $_GET['perpg'];
}
else
{
        $perpage = 20;
}

// ordering
if(isset($_GET['order']) && trim($_GET['order']) != '')
{
        $orderby = $_GET['order'];
}
else
{
        $orderby = 'id';
}

// order direction
if(isset($_GET['dir']) && trim($_GET['dir']) != '')
{
        $dir = $_GET['dir'];
}
else
{
        $dir = 'ASC';
}

// back link
if($current == 0)
{
        // no back link
        $back_link = $lang['back'];
}
else
{
        // make the back link
        $back_link = '<a href="member_list.php?cur=' . ($current - $perpage) . '&perpg=' . $perpage . '&order=' . $orderby . '&dir=' . $dir . '">' . $lang['back'] . '</a>';
}

if($perpage == 'all')
{
        $limit_sql = '';
}
else
{
        $limit_sql = "LIMIT " . ($current + $perpage) . ",$perpage";
}

$num = 0;
$sql = "SELECT * FROM players
                ORDER BY $orderby $dir $limit_sql";

$result = $db->db_query($sql);
while($row = $db->db_fetch_array($result))
{
        $user_list .= "<tr><td><img src=\"images/pc/$row[char_img].gif\"></td><td><a href=\"view_profile.php?id=$row[name]\">$row[name]</a></td><td>$row[level]</td><td>$row[class]</td><td>$row[gold]</td></tr>";
        $num++;
}

// next link
if($num < $perpage || $perpage == 'all')
{
        // no forward link
        $next_link = $lang['next'];
}
else
{
        $next_link = '<a href="member_list.php?cur=' . ($current + $perpage) . '&perpg=' . $perpage . '&order=' . $orderby . '&dir=' . $dir . '">' . $lang['next'] . '</a>';
}

$hp_graph = makegraph($user[13], $user[14], 'HP: ', 'red');
$mp_graph = makegraph($user[15], $user[16], 'MP: ', 'blue');

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

$script_header = <<<html
<map name="1">
</map>
<script language="javascript" src="includes/javascript.js"></script>
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

// talk and fight buttons (inactive right now)
$talkButton = '<img src="templates/' . $config['template'] . '/images/action_talk.gif" alt="Talk with nearby charactors" border="0">';
$fightButton = '<img src="templates/' . $config['template'] . '/images/action_fight.gif" alt="Fight with a nearby monster" border="0">';

// list of users online
$online_list = online_list();

// direction links
$desc_link = "<a href=\"member_list.php?cur=$current&perpg=$perpage&order=$orderby&dir=desc\">$lang[desc_order]</a>";
$asc_link = "<a href=\"member_list.php?cur=$current&perpg=$perpage&order=$orderby&dir=asc\">$lang[asc_order]</a>";

$page = new Template();

$page->set_files(array(
'body' => 'memberlist_body.tpl'));

$page->assign_vars(array(
'page_script_header' => $script_header,
'talk_button' => $talkButton,
'fight_button' => $fightButton,
'chat_toggle' => '',
'chat_frame' => '',
'user_name' => $user['name'],
'user_level' => $user['level'],
'user_class' => $user['class'],
'user_exp' => $user['exp'],
'name' => $row['name'],
'level' => $row['level'],
'class' => $row['class'],
'exp' => $row['exp'],
'hp_graph' => $hp_graph,
'mp_graph' => $mp_graph,
'user_gold' => $user['gold'],
'music_link' => '',
'index_message' => $index_message,
'index_div' => $message_top_left,
'online_list' => $online_list,
'list' => $user_list,
'next_link' => $next_link,
'back_link' => $back_link,
'perpg' => $perpage,
'desc_link' => $desc_link,
'asc_link' => $asc_link));

$page->ppage();

// debug information
if($debug == 1)
{
        attach_debug();
}
?>
