<?PHP
require('includes/startup.php');

// Selecting all information for user
$sql = "SELECT * FROM players
                WHERE name = '$_GET[id]'";

$result = $db->db_query($sql);
$num = mysql_num_rows($result);


$row = $db->db_fetch_array($result);


if($row[19] == 1)
{
        $usrlvl = "Member";
}
elseif($row[19] == 2)
{
        $usrlvl = "Moderator";
}
elseif($row[19] == 3)
{
        $usrlvl = "Administrator";
}
elseif($row[19] == 4)
{
        $usrlvl = "<i>Banned</i>";
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
        $chatToggle = '[<a href="index.php?chat=0">-</a>]';
}
else
{
        $chatToggle = '[<a href="index.php?chat=1">+</a>]';
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

// change @ to [at] in email to prevent spam

$page = new Template();

$page->set_files(array(
'body' => 'profile_body.tpl'));

$page->assign_vars(array(
'page_script_header' => $script_header,
'talk_button' => $talkButton,
'fight_button' => $fightButton,
'chat_toggle' => $chatToggle,
'chat_frame' => $chatFrame,
'user_name' => $user['name'],
'user_level' => $user['level'],
'user_class' => $user['class'],
'user_exp' => $user['exp'],
'name' => $row['name'],
'level' => $row['level'],
'class' => $row['class'],
'email' => $row['email'],
'exp' => $row['exp'],
'rank' => $usrlvl,
'hp_graph' => $hp_graph,
'mp_graph' => $mp_graph,
'user_gold' => $user['gold'],
'music_link' => '',
'index_message' => $index_message,
'index_div' => $message_top_left,
'online_list' => $online_list,
'gold' => $row['gold']));

$page->ppage();

// debug information
if($debug == 1)
{
        attach_debug();
}
?>
