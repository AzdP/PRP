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

require("includes/startup.php");

// make sure this is a valid monster to battle
if($_SESSION['in_fight'] != 1 && !strstr($_SESSION['valid_monsters'], $_GET['monster']))
{
        header("Location: index.php");
        exit;
}

// instantiate battle class
$battle = new Battle();

// declare variables
$msg = '';
$special_msg = '';

// setup sessions if they aren't already...
if($_SESSION['in_fight'] == 0)
{
        $sql = "SELECT * FROM monsters
                WHERE id = '$_GET[monster]'";

        $result = $db->db_query($sql);
        $monster = $db->db_fetch_array($result);

        // do we need to scale the HP/level?
        $level = $monster['level'];
        $total_hp = $monster['hp'];
        $max_hp = $monster['hp'];
        if($monster['hp'] == -1)
        {
                // scale HP
                $level = rand(0 + $user['level'], 5 + $user['level']);
                $total_hp = rand(5 + $level, 10 + $level);
                $max_hp = $total_hp;
        }

        $_SESSION['in_fight'] = 1;
        $_SESSION['monsterid'] = $monster['id'];
        $_SESSION['monster_level'] = $level;
        $_SESSION['pos_id'] = $_GET['monster'];
        $_SESSION['monster_dmg'] = $total_hp;
        $_SESSION['monster_maxhp'] = $max_hp;
        $_SESSION['exp_gain'] = 0;
}
else
{
        $sql = "SELECT * FROM monsters
                WHERE id = '$_SESSION[monsterid]'";

        $result = $db->db_query($sql);
        $monster = $db->db_fetch_array($result);
}

// are we attacking?
if(isset($_POST['attack']))
{
        $hit = $battle->checkHit($_POST['attack']);

        // if it missed lets just say so and be done with it!
        if($hit == 0)
        {
                $msg .= "Attack Failed!";
        }
        else
        {
                // else lets see how much damage its going to do...
                $dmg = rand($battle->attackMin, $battle->attackMax);

                // take the damage away from the monsters health
                $_SESSION['monster_dmg'] -= $dmg;

                $msg .= "<br>Attack successful! $dmg damage was done to opponent!";

                // experience points from hitting this dude?
                if($dmg != 0)
                {
                        $index_message .= $battle->calcLevel($_SESSION['monster_level'], $dmg);
                }

                // lets "kick" this guy to see if he's dead
                if($_SESSION['monster_dmg'] <= 0)
                {
                        // is it a random battle?
                        if($_SESSION['randbattle'] == TRUE)
                        {
                                // not in a random battle anymore
                                $_SESSION['randbattle'] = FALSE;
                        }
                        else
                        {
                                // we don't need to do this if its a random battle
                                // update the monster so he disappears on the map!
                                $time = time();

                                $sql = "UPDATE monster_pos
                                        SET killed = '1', time_killed = '$time'
                                        WHERE id = '$_SESSION[pos_id]'";

                                $result = $db->db_query($sql);
                        }

                        // should this user get some gold??
                        $battle->calcGold($_SESSION['monster_level']);

                        header("Location: index.php");
                        exit;
                }
        }

        // now its the monsters turn! RAR!

        // is it going to hit?
        $hit = rand(0,1);

        // if not lets just say so and be done with it
        if($hit == 0)
        {
                $msg .= '<br />Your opponent\'s attack missed!';
        }
        else
        {
                //
                // else lets see what attacks this dude has...
                // if there is only one (multiples are seperated by commas)
                // we'll just go with that and not do an explode()
                //
                $attacks = $monster['attacks'];
                if($attacks == 'scaled')
                {
                        // the attacks are scaled
                        $attack_list = '';

                        $sql = "SELECT * FROM attacks
                                WHERE level <= '$_SESSION[monster_level]'";

                        $result = $db->db_query($sql);
                        while($row = $db->db_fetch_array($result))
                        {
                                if(isset($num))
                                {
                                        $attack_list .= ",$row[id]";
                                }
                                else
                                {
                                        $attack_list .= "$row[id]";
                                }

                                $num = 1;
                        }
                }
                else
                {
                        $attack_list = $monster['attacks'];
                }

                if(strstr($attack_list, ","))
                {
                        $attks = explode(",", $attack_list);
                        $num = 0;

                        // lets randomize an attack that is allowable for the level our user has
                        foreach($attks as $value)
                        {
                                $sql = "SELECT * FROM attacks";

                                $result = $db->db_query($sql);
                                $attack = $db->db_fetch_array($result);

                                if($attack[4] <= $user['level'])
                                {
                                        $attacks[$num] = $attack[0];
                                        $num++;
                                }
                        }
                        $num = count($attacks) - 1;
                        $do = $attacks[rand(0,$num)];
                }
                else
                {
                        // it just has one attack option
                        $do = $attack_list;
                }

                // come up with the information for this attack
                $sql = "SELECT * FROM attacks
                        WHERE id = '$do'";

                $result = $db->db_query($sql);
                $attack = $db->db_fetch_array($result);

                // how much damage are we going to do here?
                $dmg = rand($attack[2], $attack[3]);

                if($dmg == 0)
                {
                        $dmg = 1;
                }

                // calculate the new hp value for the user
                $new_hp = $user[13] - $dmg;

                // lets update the sql db with the new hp for the user!! HA sucker
                $sql = "UPDATE players
                        SET hp = '$new_hp'
                        WHERE name = '$_SESSION[usr_logged]'";

                $result = $db->db_query($sql);

                // send a message to the player letting them know they've been hurtedededed
                $msg .= "<br>You've been hit! $dmg damage has been done.";
        }

        //
        // PHEW all done! well after all that lets go ahead and
        // update the user information so the graphs are updated
        //
        $sql = "SELECT * FROM players
                WHERE id = '$user[id]'";

        $result = $db->db_query($sql);
        $user = $db->db_fetch_array($result);

        // and now we run a subroutine to find if the user has been killed, if
        // they have they'll be returned to the default sector and redirected.
        $chkdead = $player->checkIfDead();

        //
        // ALL DONE WITH THE BATTLE CALCULATING
        //
}

$sql = "SELECT * FROM weapons
        WHERE id = '$user[18]'";

$result = $db->db_query($sql);
$equip1 = $db->db_fetch_array($result);

$hp_graph = makegraph($user[13], $user[14], 'HP: ', 'red');
$mp_graph = makegraph($user[15], $user[16], 'MP: ', 'blue');

// now we gotta grab the sector information
$sql = "SELECT * FROM sectors
        WHERE id = '$user[sector]'";

$result = $db->db_query($sql);
$sector = $db->db_fetch_array($result);

//
// Setup the graphical interface
//
if(!isset($_SESSION['monster_dmg']))
{
        $monster_dmg = $monster[3];
}
else
{
        $monster_dmg = $_SESSION['monster_dmg'];
}

$attack_options = '';
if($user[18] != '')
{
        $attack_options = '<option value="equip1">'.$equip1['name'].'</option>';
}

$monster_hp = makegraph($monster_dmg,$_SESSION['monster_maxhp'],'HP: ','red');

$body_html = <<<html
<table width="400" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="206" background="images/background/$sector[2].gif">
  <tr>
    <td width="200" height="206">
    <p align="center"><img src=images/pc/$user[6].gif alt="$user[name]"><br>
    <br>
    <form action="fight.php" method="post"><select name="attack"><option value="1">Punch</option>$attack_options</select><input type="submit" value="attack"></form></td>
    <td width="200" height="206">
    <p align="center">
    <img src="images/monsters/$monster[2].gif"><br>
    <br>
    $monster[name]<br>
        $monster_hp
        <br><br><br>
        </td>
  </tr>
</table>
<center>$msg</center>
html;

$script_header = <<<html
<map name="1">
</map>
<script language="javascript" src="includes/javascript.js"></script>
html;

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

// talk and fight buttons (inactive right now)
$talkButton = '<img src="templates/' . $config['template'] . '/images/action_talk.gif" alt="Talk with nearby charactors" border="0">';
$fightButton = '<img src="templates/' . $config['template'] . '/images/action_fight.gif" alt="Fight with a nearby monster" border="0">';

// list of users online
$online_list = online_list();

// generate a code so that the index messages can be displayed in the top left of the game window
$message_top_left = <<<html
<div style="position:absolute;left:$xoffset px;top:$yoffset px;visibility: visible;z-index:999;">
$index_message
</div>
html;

$page = new Template();

$page->set_files(array(
'body' => $body_html));

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
'move_up' => '',
'move_left' => '',
'move_right' => '',
'move_down' => '',
'hp_graph' => $hp_graph,
'mp_graph' => $mp_graph,
'user_gold' => $user['gold'],
'music_link' => $sector['music'],
'index_message' => $index_message,
'online_list' => $online_list,
'index_div' => $message_top_left,
'attack_options' => $attack_options));

$page->ppage();

// debug information
if($debug == 1)
{
        attach_debug();
}
?>
