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

        // Begin Startup Functions
// debug?
$debug = 1;

if($debug == 1)
{
        // set php error reporting to the highest level
        error_reporting(E_ALL);

        //initialize debug variables
        $num_queries = 0;
        $query_text = '';

        //start recording page load time
        $pagetime1 = microtime();
}

// start sessions
session_start();

// Checking to see if cookie is set and if they're not logged in
if(isset($_COOKIE['usr_logged']) && !session_is_registered('usr_logged'))
{
                $_SESSION['usr_logged'] = $_COOKIE['usr_logged'];
                $_SESSION['in_fight'] = 0;
                $_SESSION['chat'] = 1;
                $_SESSION['valid_monsters'] = '';
                $_SESSION['randbattle'] = false;

                // pvp sessions
                $_SESSION['pvp_battling'] = false;
                $_SESSION['pvp_status'] = false;
                $_SESSION['pvp_battleid'] = false;
}

// declare the variable used for system messages
$index_message = '';

// Include various files we'll need
require("./settings.php");
require("./includes/db.inc.php");
require("./includes/functions.inc.php");
require("./includes/class.inc.php");
require("./includes/template.inc.php");
require("./language/english.php");

// Connect to the SQL DB
$db = new db($db['host'], $db['user'], $db['pass'], $db['name']);

if(!$db->db_connection)
{
        die("Connection Error");
}

// Grab settings
$sql = 'SELECT * FROM config';

$result = $db->db_query($sql);

while($row = $db->db_fetch_array($result))
{
        $config[$row['config_name']] = $row['config_value'];
}

// now include the template configuration file
require("./templates/" . $config['template'] . "/tpl_config.php");

// Check if the user is logged in
if(session_is_registered("usr_logged"))
{
        $player = new Player;

        $user = $player->getInfo();

        // check if the user is in the online db and get an array of who is (to minimize queries
        $sql = "SELECT * FROM online";

        $result = $db->db_query($sql);

        while($row = $db->db_fetch_array($result))
        {
                $online[$row['name']] = TRUE;
        }

        $time = time();

        if(!isset($online[$user['name']]))
        {
                // if they aren't, insert them
                $sql = "INSERT INTO online
                                VALUES('$user[0]','$user[1]','$time','$_SERVER[REMOTE_ADDR]')";

                $result = $db->db_query($sql);
        }
        else
        {

                // if they are already, update the time!!
                $sql = "UPDATE online
                                SET time = '$time'
                                WHERE id = '$user[0]'";

                $result = $db->db_query($sql);
        }

        // delete old online entries from the db
        $time = time() - 300;

        $sql = "DELETE FROM online
                                WHERE time <= '$time'";

        $result = $db->db_query($sql);

                //
                // Player VS. Player Battles
                //
                // make sure this isnt pvp.php or chat.php
                if(!strstr($_SERVER['PHP_SELF'], 'pvp.php') && !strstr($_SERVER['PHP_SELF'], 'chat.php'))
                {
                        // Is the user coming defeated from a PVP battle?
                        if($_SESSION['pvp_battling'] != false && $user['hp'] <= 0)
                        {
                                // deinitalize all sessions
                                $_SESSION['pvp_battling'] = false;
                                $_SESSION['pvp_status'] = false;
                                $_SESSION['pvp_battleid'] = false;
                        }
                        else if($_SESSION['pvp_battling'] != false && $user['hp'] > 0)
                        {
                                // is the user coming victorious from a PVP battle?
                                $sql = "SELECT * FROM pvp
                                        WHERE id = '$_SESSION[pvp_battleid]'";

                                $result = $db->db_query($sql);
                                $row = $db->db_fetch_array($result);

                                if($row['won_by'] == $user['id'])
                                {
                                        // they won!
                                        // deinitalize all sessions
                                        $_SESSION['pvp_battling'] = false;
                                        $_SESSION['pvp_status'] = false;
                                        $_SESSION['pvp_battleid'] = false;

                                        $index_message .= '<font color=F5B236><b>' . $lang['pvp_won'] . '</b></font>';
                                }
                                else
                                {
                                        // send 'em back!
                                        header("Location: pvp.php");
                                        exit;
                                }
                        }
                }

        // run a subroutine to find if the user has been killed
        $index_message .= $player->checkIfDead();

        // was he just in a battle? is this battle won?
        if((isset($_SESSION['monster_dmg'])) && ($_SESSION['in_fight'] == 1) && ($_SESSION['monster_dmg'] <= 0))
        {
                // Display about of XP gained
                if(session_is_registered('exp_gain') && $_SESSION['exp_gain'] != '')
                {
                        $round = round("$_SESSION[exp_gain]");
                        $index_message .= "<font color=BFC1F2><b>You have gained $round exp!</b></font><br>";
                }

                // did he win some gold?
                if(session_is_registered('gold') && $_SESSION['gold'] != '')
                {
                        $index_message .= "<font color=FFFF59><b>You have won $_SESSION[gold] gold!</b></font><br>";
                        $_SESSION['gold'] = '';
                }

                // spit out a msg
                $index_message .= '<font color=F5B236><b>You have won the battle!</b></font>';

                // in battle is 0
                $_SESSION['in_fight'] = 0;
        }



        // Update monsters that should respawn (2 minutes)
        $time = time() - 120;

        $sql = "UPDATE monster_pos
                        SET killed = '0'
                        WHERE time_killed <= '$time'";

        $result = $db->db_query($sql);
}
else
{
        // make sure we're on the index and if we are, goto login
        if(strstr($_SERVER['PHP_SELF'], "index.php"))
        {
                // send the user to the login page!
                header("Location: login.php");
                exit;
        }
}
?>
