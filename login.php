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

if(!isset($_POST['submit']))
{

        $page = new Template();

        $page->set_files(array(
        'header' => 'simple_header.tpl',
        'body' => 'login_body.tpl',
        'footer' => 'simple_footer.tpl'));

        $page->ppage();
}
else
{
        $sql = "SELECT * FROM players
                        WHERE name = '$_POST[username]' AND password = '$_POST[password]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);
        $user = $db->db_fetch_array($result);

        // check if there are 0 matches or not
        if($num == 0)
        {
                // bad username or password
                $page = new Template();
                $page->simplePage('<center>Bad login information.<br /><a href="login.php">Back</a></center>', 1);
        }
        else if($user['userlvl'] == '4')
        {
                // they're banned!
                $page = new Template();
                $page->simplePage('You have been banned from this game.', 1);
        }
        else
        {
                // setup sessions
                $_SESSION['usr_logged'] = $_POST['username'];
                $_SESSION['in_fight'] = 0;
                $_SESSION['chat'] = 1;
                $_SESSION['valid_monsters'] = '';
                $_SESSION['randbattle'] = false;

                // pvp sessions
                $_SESSION['pvp_battling'] = false;
                $_SESSION['pvp_status'] = false;
                $_SESSION['pvp_battleid'] = false;


                // checking to see if they want to be remembered
                if(isset($_POST['remember']))
                {
                        setcookie("usr_logged", $_POST['username'],time()+2592000);
                }

                header("Location: index.php");
                exit;
        }
}
?>
