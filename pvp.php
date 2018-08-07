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
require('./includes/startup.php');
require("./includes/battles.inc.php");

// SESSION SETUP
//
// $_SESSION['pvp_battling']     - The player that the current user is in battle with
// $_SESSION['pvp_status']       - Whether the player is an attacker or defender
// $_SESSION['pvp_battleid']     - The ID of the battle row in the database that we're working with

// check to see if this is a defender trying to accept or deny the battle...
if(isset($_GET['mode']) && isset($_GET['pid']) && ($_GET['mode'] == 'accept' || $_GET['mode'] == 'deny'))
{
        // they're trying to deny or accept it...
        if($_GET['mode'] == 'accept')
        {
                // make sure its not cancelled
                $sql = "SELECT * FROM pvp
                        WHERE id = '$_GET[pid]'";

                $result = $db->db_query($sql);
                $row = $db->db_fetch_array($result);

                if($row['accepted'] == -1)
                {
                        // its been cancelled
                        header("Location: index.php");
                        exit;
                }

                // they're accepting it
                $sql = "UPDATE pvp
                        SET accepted = '1'
                        WHERE id = '$_GET[pid]'";

                $result = $db->db_query($sql);

                $sql = "SELECT challenger,accepted FROM pvp
                        WHERE id = '$_GET[pid]'";

                $result = $db->db_query($sql);
                $row = $db->db_fetch_array($result);

                // make sure they haven't cancelled!
                if($row['accepted'] == -1)
                {
                        // they quit
                        $page = new Template();
                        $page->normalPage($lang['battle_cancelled']);
                        exit;
                }

                // set sessions, then refresh
                $_SESSION['pvp_battling'] = $row['challenger'];
                $_SESSION['pvp_status'] = 'attacker';
                $_SESSION['pvp_battleid'] = $_GET['pid'];

                header("Location: pvp.php");
                exit;
        }
        else
        {
                // they're denying it! (weaklings)
                $sql = "UPDATE pvp
                        SET accepted = '-1'
                        WHERE id = '$_GET[pid]'";

                $result = $db->db_query($sql);

                // go back to index page
                header("Location: index.php");
                exit;
        }
}

// make sure the user is trying to start a battle or join one
if(!isset($_GET['fight']) && $_SESSION['pvp_battling'] == false)
{
        header("Location: index.php");
        exit;
}

// setup which side the user is on
$user_side = $_SESSION['pvp_status'];

// ok, is this the attacker or defender?
// this should only run if it's not already set
if(isset($_GET['fight']) && $_SESSION['pvp_status'] == false)
{
        $_SESSION['pvp_status'] = 'defender';
        $user_side = 'defender';
}

if($_SESSION['pvp_battleid'] != FALSE)
{
        // battle already has been inserted, lets see if it's been accepted
        $sql = "SELECT * FROM pvp
                WHERE id = '$_SESSION[pvp_battleid]'";

        $result = $db->db_query($sql);
        $fight_info = $db->db_fetch_array($result);

        // has it been accepted?
        if($fight_info['accepted'] == 1)
        {
                // yep. :)

                // now lets draw out the fight form... its in a function
                // to make things easier
                pvp_battle();
                exit;
        }
        else if($fight_info['accepted'] == -1)
        {
                // the fight has been declined

                // unset sessions
                $_SESSION['pvp_battleid'] = false;
                $_SESSION['pvp_status'] = false;
                $_SESSION['pvp_battling'] = false;

                $output = 'The user has denied your request.';
        }
        else if($fight_info['accepted'] == 0)
        {
                // user want to cancel?
                if(isset($_GET['cancel']) && $_GET['cancel'] == '1')
                {
                        // they want to cancel the request
                        // update db
                        $sql = "UPDATE pvp
                                SET accepted = '-1'
                                WHERE id = '$_SESSION[pvp_battleid]'";

                        $result = $db->db_query($sql);

                        // unset sessions
                        $_SESSION['pvp_battleid'] = false;
                        $_SESSION['pvp_status'] = false;
                        $_SESSION['pvp_battling'] = false;

                        $output = $lang['pvp_cancelled'];
                        $output .= '<meta http-equiv="refresh" content="2;url=index.php">';
                }
                else
                {
                        // still waiting...
                        $output = $lang['pvp_waiting'] . '<br><br><a href="pvp.php?cancel=1">' . $lang['pvp_cancel'] . '</a>';
                        $output .= '<meta http-equiv="refresh" content="5">';
                }
        }
}
else
{
        // make sure the user is valid
        $sql = "SELECT * FROM players
                WHERE id = '$_GET[fight]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num == 0)
        {
                // no such user
                $page = new Template();
                $page->normalPage($lang['no_such_user']);
                exit;
        }

        // make sure the user is online
        $sql = "SELECT * FROM online
                WHERE id = '$_GET[fight]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num == 0)
        {
                // the user is not online
                $page = new Template();
                $page->normalPage($lang['user_not_online']);
                exit;
        }

        // make sure the user isn't already in a battle or challenged
        $sql = "SELECT * FROM pvp
                WHERE (challenger = '$_GET[fight]' OR defender = '$_GET[fight]') AND won = '0' AND accepted != '-1'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num > 0)
        {
                // the user is already in a battle
                $page = new Template();
                $page->normalPage($lang['user_in_battle']);
                exit;
        }

        // now lets enter it into the db!
        $time = time();

        $sql = "INSERT INTO pvp (id,challenger,defender,accepted,lastmove_time,lastmove_player,won,won_by,battle_time,messages)
                        VALUES ('', '$user[id]', '$_GET[fight]', '0', '$time', '$user[id]', '0', '0', '$time', 'The battle has begun!')";

        $result = $db->db_query($sql);

        // now get the ID of the battle
        $sql = "SELECT id FROM pvp
                WHERE battle_time = '$time'";

        $result = $db->db_query($sql);
        $row = $db->db_fetch_array($result);

        $_SESSION['pvp_battling'] = $_GET['fight'];
        $_SESSION['pvp_battleid'] = $row['id'];
        $_SESSION['pvp_status'] = 'defender';

        // wait for the user to accept it
        $output = $lang['pvp_waiting'];
        $output .= '<meta http-equiv="refresh" content="5">';
}

$page = new Template();

$page->normalPage($output);
?>