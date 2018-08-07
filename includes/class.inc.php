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
//        This file houses the game classes of PRP!

//                - This first class is used to manipulate the current players information
class Player
{
        var $sql;
        var $result;
        var $user;

        //
        //        Start things off by getting an array of user information from the database
        //
        function getInfo()
        {
                global $db;
                $this->sql = "SELECT * FROM players
                                WHERE name = '$_SESSION[usr_logged]'";

                $this->result = $db->db_query($this->sql);
                $this->user = $db->db_fetch_array($this->result);

                // return the user's information
                return $this->user;
        }

        //
        // This function is used to change the position of the player
        //
        function changePos($newX, $newY, $sector = '')
        {
                global $db,$user;

                if($sector != '')
                {
                        $sectorSQL = ", sector = '$sector'";
                }
                else
                {
                        $sectorSQL = '';
                }

                $this->sql = "UPDATE players
                                          SET x = '$newX', y = '$newY'$sectorSQL
                                          WHERE id = '$user[id]'";

                $this->result = $db->db_query($this->sql);

                if($this->result)
                {
                        return TRUE;
                }
                else
                {
                        die('Error: Could not change player position!');
                }

                return false;
        }

        //
        // This function is used to securely update an individual statistic
        //
        function updateStat($new, $stat)
        {
                $stat = strtolower($stat);        // change to lower case just in case

                // first of all make sure that the stat is valid by comparing it in an array
                $validStats = array(
                'sector',
                'level',
                'exp',
                'hp',
                'maxhp',
                'mp',
                'maxmp',
                'gold',
                'equip1');

                if(!in_array($stat, $validStats))
                {
                        return FALSE;
                }

                $sql = "UPDATE players
                                SET $stat = '$new'
                                WHERE id = '$user[id]'";
                $result = $db->db_query($sql);

                if($result)
                {
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }

        //
        // This function checks if the players is dead then handles it
        //
        function checkIfDead()
        {
                global $user, $db;

                $msg = '';

                if($user[13] <= 0)
                {
                        // make sure they're in the world or in a battle
                        if(strstr($_SERVER['PHP_SELF'], "fight.php"))
                        {
                                // if they're in a battle we'll need to destroy fight sessions
                                $_SESSION['in_fight'] = null;
                                $_SESSION['monsterid'] = null;
                                $_SESSION['monster_level'] = null;
                                $_SESSION['pos_id'] = null;
                                $_SESSION['monster_dmg'] = null;
                                $_SESSION['monster_maxhp'] = null;
                                $_SESSION['exp_gain'] = null;

                                // redirect to the index, then this function will run again because the user is still dead...
                                header("Location: index.php");
                                exit;
                        }
                        else
                        {
                                // if the user is dead we'll go ahead and stick them in the first sector...
                                $sql = "UPDATE players
                                        SET sector = '1', hp = '1'
                                        WHERE id = '$user[id]'";

                                $result = $db->db_query($sql);

                                // destroy PVP sessions
                                $_SESSION['pvp_battling'] = false;
                                $_SESSION['pvp_status'] = false;
                                $_SESSION['pvp_battleid'] = false;

                                // now we give a message that they've been killed
                                $msg .= '<font color="red"><b>You have been killed!</b></font>';

                                // Obtain user data again from the database because we've just changed it
                                $sql = "SELECT * FROM players
                                                WHERE name = '$_SESSION[usr_logged]'";

                                $result = $db->db_query($sql);
                                $user = $db->db_fetch_array($result);
                        }
                }
                return $msg;
        }

        //
        // Use this function to buy/add a weapon
        //
        function addWeapon($id, $justAdd = FALSE)
        {
                global $user, $db;

                // get info about the item that the player wants
                $sql = "SELECT * FROM weapons
                                WHERE id = '$id'";

                $result = $db->db_query($sql);
                $item = $db->db_fetch_array($result);

                // check if the player has enough gold
                if($user[17] < $item[6])
                {
                        simplePage('You do not have enough gold to purchase this item! Come back when you have sufficient funds.', 1);
                }

                // calculate the users new gold value
                $new_gold = $user[17] - $item[6];

                // check to see if the user already has the same item,
                // if he does then just add to the quantity
                $sql = "SELECT * FROM inventory
                                WHERE pid = '$user[0]' AND item_id = '$item[0]' AND type = 'weapon'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);
                if($num == 0)
                {
                        // go ahead and add the item to the players inventory. Also make sure to deduct the ammount of gold spent.....
                        $sql = "INSERT INTO inventory (pid,type,item_id,quantity)
                                        VALUES ('$user[0]', 'weapon', '$item[0]', '1')";

                        $result = $db->db_query($sql);
                }
                else
                {
                        // this item is alreay added... just add one to the count!
                        $inventory = $db->db_fetch_array($result);
                        $new_num = $inventory[3] + 1;

                        $sql = "UPDATE inventory
                                        SET quantity = '$new_num'
                                        WHERE pid = '$user[0]' AND type = 'weapon' AND item_id = '$item[0]'";

                        $result = $db->db_query($sql);
                }

                $sql = "UPDATE players
                                SET gold = '$new_gold'
                                WHERE name = '$_SESSION[usr_logged]'";

                $result = $db->db_query($sql);
        }

        //
        // This function will add/buy an item
        //
        function addItem($itemid, $justAdd = FALSE)
        {
                global $db, $user;

                // get info about the item
                $sql = "SELECT * FROM items
                                WHERE id = '$itemid'";

                $result = $db->db_query($sql);

                $item = $db->db_fetch_array($result);

                // enough gold?
                if($item['value'] > $user['gold'])
                {
                        simplePage('You do not have enough gold to buy this item!', 1);
                }

                // new gold
                $new_gold = $user['gold'] - $item['value'];

                // update gold
                $sql = "UPDATE players
                                SET gold = '$new_gold'
                                WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                // already got this item?
                $sql = "SELECT * FROM inventory
                                WHERE item_id = '$itemid' AND type = 'item' AND pid = '$user[id]'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);

                if($num != 0)
                {
                        // if the player already has the item then just update the count
                        $row = $db->db_fetch_array($result);

                        $new = $row['quantity'] + 1;
                        $sql = "UPDATE inventory
                                        SET quantity = '$new'
                                        WHERE item_id = '$itemid' AND type = 'item' AND pid = '$user[id]'";
                }
                else
                {
                        // insert a new row for the user if there is not already one
                        $sql = "INSERT INTO inventory (pid,type,item_id,quantity)
                                        VALUES ('$user[id]', 'item', '$itemid', '1')";
                }

                $result = $db->db_query($sql);
        }

        //
        // This function is used to check if the user is being challenged
        //
        function checkChallenge()
        {
                // check the database for challenges
                $sql = "SELECT * FROM pvp
                                WHERE defender = '$user[id]'
                                AND won = '0'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);

                if($num > 0)
                {
                        // the user has been challenged

                        // register sessions if not already
                        if(!session_is_registered('defender'))
                        {
                                session_register('defender');
                        }
                        $_SESSION['defender'] = TRUE;

                        // redirect to the PVP script
                        header('Location: pvp.php');
                        exit;
                }
        }

        //
        // This function will check to see if the user is being challenged in a PVP battle
        //
        function checkPVP()
        {
                global $user, $db;

                // declare vars
                $output['ask'] = false;
                $output['pvp_info'] = '';

                $sql = "SELECT * FROM pvp
                        WHERE defender = '$user[id]' AND accepted = '0'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);

                if($num > 0)
                {
                        // the user is being challenged!! ask them if they want to accept
                        // later on in the page (just set a variable for now...)
                        $output['pvp_info'] = $db->db_fetch_array($result);
                        $output['ask'] = $output['pvp_info']['id'];
                }

                return $output;
        }

        //---------------------------------------------------
}

//                - This class handles all player chat functions in the game
class Chat
{
        var $chatHTML;

        //
        // Get a formatted HTML version of every chat message, should be all ready for echo() once this is done!
         //
        function getChat()
        {
                global $db, $num_chats, $chat_name_length;

                $sql = "SELECT * FROM chat
                                WHERE public = '1' ORDER BY id DESC LIMIT $num_chats";

                $result = $db->db_query($sql);

                while($row = $db->db_fetch_array($result))
                {

                        $sql1 = "SELECT * FROM players WHERE name='$row[user]'";
                              $result1 = $db->db_query($sql1);
                        $player = $db->db_fetch_array($result1);

                        if($player['userlvl'] == "3")
                        {
                        $admin = '<img src=./images/admin.gif> ';
                        }
                        else
                        {
                        $admin = '';
                        }


                        // Checking to see if user has Colored Username for Chat
                        if($player['chatcolor'] == "0") {
                        $color = "#000000";
                        } else {
                        $color = $player['chatcolor'];
                        }
                               $bgcolor = "#FFFFFF";


                        $message = stripslashes($row['message']);

                        if(strlen($row['user']) > $chat_name_length)
                        {
                                $user = substr($row['user'], 0, $chat_name_length) . '..';
                        }
                        else
                        {
                                $user = $row['user'];
                        }

                        // Check for Profanity Filter
                        /*
                        $sql3 = "SELECT profanity_filter FROM player WHERE name = '$_SESSION[usr_logged]'";
                        $result3 = $db->db_query($sql3);
                        $player3 = $db->db_fetch_array($result3);

                        if($player3[profanity_filter] == "1")
                        {
                                $filter = profanity_filter($message);
                        }
                        else
                        {
                                $filter = $message;
                        }
                        */

                        $this->chatHTML .= "<tr><td valign=top bgcolor=\"$bgcolor\" width=\"20%\"><font color=\"$color\"><b>$admin$user</b>:</font></td><td bgcolor=\"$bgcolor\">$message</td></tr>\n";
                }

                return $this->chatHTML;
        }

        //
        // This function will add a chat message to the database
        //
        function addChat($msg, $public = 1)
        {
                global $db;

                // clean up the message and get the time
                $time = time();
                $msg = addslashes($msg);
                $msg = trim($msg);
                $msg = htmlspecialchars($msg);
                        $sql1 = "SELECT * FROM players WHERE name='$_SESSION[usr_logged]'";
                        $result1 = $db->db_query($sql1);
                        $player = $db->db_fetch_array($result1);

                if($msg == "/clear" && $player[userlvl] == "3")
                {
                mysql_query("DELETE * FROM chat");
                }

                $sql = "INSERT INTO chat (id,user,time,message,public)
                                VALUES('', '$_SESSION[usr_logged]', '$time', '$msg', '$public')";

                $result = $db->db_query($sql);

                return TRUE;
        }
}

// - This class is used to control clans in the game
class ClanManager
{
        //
        // Return an arary of clan db information
        //
        function clanInfo($id)
        {
                // make the query
                $sql = "SELECT * FROM clans
                        WHERE id = '$clan'";

                $result = $db->db_query($sql);
                $clan = $db->db_fetch_array($result);

                return $clan;
        }

        //
        // Function used to create a clan
        //
        function makeClan($name, $description, $tax, $allow_new, $signup_fee, $creation_fee = true)
        {
                global $db, $user, $config;

                // is money an issue?
                if($creation_fee == true)
                {
                        // do they have enough money?
                        if($user['gold'] < $config['clan_fee'])
                        {
                                return false;
                        }

                        // deduct the creation fee from the user's money
                        $new_gold = $user['gold'] - $config['clan_fee'];

                        $sql = "UPDATE players
                                SET gold = '$new_gold'";

                        $result = $db->db_query($sql);
                }

                // now add the clan
                $sql = "INSERT INTO clans
                        VALUES ('', '$name', '$description', '', '0', '$user[id]', '', '', '$tax', '', '', '', '$allow_new', '$signup_fee')";

                $result = $db->db_query($sql);

                return true;
        }

        //
        // Add a member to a clan
        //
        function addMember($clan, $user)
        {
                global $db, $user;

                // get current clan info
                $clan_info = $this->clanInfo($clan);

                // now add the user in and update the user count
                $new_memberlist = $clan_info['members'] . ',' . $user;

                $sql = "UPDATE clans
                        SET members = '$new_memberlist', members_count += '1'
                        WHERE id = '$clan'";

                $result = $db->db_query($sql);

                return true;
        }

        //
        // Remove a user from a clan
        //
        function deleteMember($clan, $user)
        {
                // get current clan info
                $this->clanInfo($clan);

                // now delete the user
                $new_memberlist = str_replace(',' . $user, '', $clan['info_members']);

                $sql = "UPDATE clans
                        SET members = '$new_memberlist', members_count += '1'
                        WHERE id = '$clan'";

                $result = $db->db_query($sql);

                return true;
        }

        //
        // Return a list of clans
        //
        function clanList($sortby = 'id')
        {
                global $db, $user, $lang;

                $sql = "SELECT * FROM clans";

                $result = $db->db_query($sql);

                // now make a list
                $list = '';
                while($row = $db->db_fetch_array($result))
                {
                        if($row['allow_new'] == 1)
                        {
                                $new_members = $lang['yes'];
                        }
                        else
                        {
                                $new_members = $lang['no'];
                        }

                        $list .= "<tr><td>$row[name]</td><td>$row[members_count]</td><td>$new_members</td><td>$row[signup_fee]</td></tr>";
                }

                return $list;
        }

        //
        // Function used to pay the tax from a clan
        //
        function payTax($clan, $user)
        {
                global $db, $user, $lang;

                // first get the clan info
                $clan = $this->clanInfo($clan);

                // now deduct the tax
                if($user['gold'] < $clan['member_tax'])
                {
                        return false;
                }

                $user_gold = $user['gold'] - $clan['member_tax'];
                $paid_members = $clan['paid_members'] . ",$user[name]";

                $sql = "UPDATE players
                        SET gold = '$user_gold'
                        WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                return true;
        }
}

class Battle
{
        var $attackMin;
        var $attackMax;
        var $attackLevel;

        function checkHit($attack)
        {
                global $db, $user;

                // get info about this attack...
                if($attack != "equip1")
                {
                        // the maximum damage
                        $this->attackMax = $user['level'] * 3 / 2;
                        $this->attackMax = ceil($this->attackMax);

                        // the minimum damage
                        $this->attackMin = 0;

                        $this->attackLevel = 1;
                }
                else
                {
                        //
                        // The user is attack with a weapon
                        //
                        $sql = "SELECT * FROM weapons
                                WHERE id = '$user[equip1]'";

                        $result = $db->db_query($sql);
                        $attack = $db->db_fetch_array($result);

                        // define variables
                        $this->attackMax = $attack['max_damage'];
                        $this->attackMin = $attack['min_damage'];
                        $this->attackLevel = $attack['level'];
                }

                // is it going to hit?
                $chance = round($user[10] - $this->attackLevel);

                if($chance == 0)
                {
                        $chance = 1;
                }

                $hit = rand(0,$chance);

                return $hit;
        }

        function calcLevel($level, $dmg)
        {
                global $db, $user, $index_message;

                $exp_gain = ceil(abs(($dmg + $level) / ($user['level'] / 5)));
                $new_exp = $user['exp'] + $exp_gain;

                $_SESSION['exp_gain'] += $exp_gain;

                // update the db with new exp!
                $sql = "UPDATE players
                        SET exp = '$new_exp'
                        WHERE id = '$user[id]'";

                $result = $db->db_query($sql);

                // is it time for the user to level up?
                if($new_exp >= ($user[10] . '00'))
                {
                        $new_level = $user[10] + 1;

                        if($user[11] == 'Warrior')
                        {
                                $new_max_hp = $user[13] + (($new_level * 3) / 2);
                                $new_max_mp = $user[15] + (($new_level * 2) / 2);
                        }
                        else
                        {
                                $new_max_hp = $user[13] + (($new_level * 2) / 2);
                                $new_max_mp = $user[15] + (($new_level * 3) / 2);
                        }

                        $sql = "UPDATE players
                                SET level = '$new_level', exp = '0', hp = '$new_max_hp', maxhp = '$new_max_hp', mp = '$new_max_mp', maxmp = '$new_max_mp'
                                WHERE name = '$_SESSION[usr_logged]'";

                        $result = $db->db_query($sql);

                        $index_message = '<b>You have leveled up!</b><br>';
                }

                return $index_message;
        }

        function calcGold($level)
        {
                global $db, $user;

                $rgold = rand(0,100);
                if($rgold > 60)
                {
                        // how much gold?
                        $gold = ($user['level'] + $_SESSION['monster_level']) / 2;
                        $gold = ceil($gold);

                        $newgold = $user['gold'] + $gold;
                        $_SESSION['gold'] = $gold;

                        $sql = "UPDATE players SET gold = '$newgold'
                                WHERE name = '$_SESSION[usr_logged]'";

                        $result = $db->db_query($sql);
                }
        }
}
?>
