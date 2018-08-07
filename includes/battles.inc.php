<?php
// Function used to handle attacks in battle
function calculate_attack()
{
        global $db, $user, $lang, $opp;

        $msg = '';

        if($_POST['attack'] != "equip1")
        {
                // it's a punch...

                // the maximum damage
                $attackMax = $user['level'] * 3 / 2;
                $attackMax = ceil($attackMax);

                // the minimum damage
                $attackMin = 0;

                $attackLevel = 1;
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
                $attackMax = $attack['max_damage'];
                $attackMin = $attack['min_damage'];
                $attackLevel = $attack['level'];
        }

        // is it going to hit?
        $chance = round($user['level'] - $attackLevel);

        if($chance <= 0)
        {
                $chance = 1;
        }

        $hit = rand(0,$chance);

        // if it missed lets just say so and be done with it!
        if($hit == 0)
        {
                $msg .= "<br>Attack directed at $opp[name] failed!";
        }
        else
        {
                // else lets see how much damage its going to do...
                $dmg = rand($attackMin, $attackMax);

                // take the damage away from the opponent's health
                $newhp = $opp['hp'] - $dmg;

                $msg .= "<br>$dmg damage was done to $opp[name]";

                // see if they've won...
                if($newhp <= 0)
                {
                        // update the battle in the DB
                        $sql = "UPDATE pvp
                                SET won = '1', won_by = '$user[id]'
                                WHERE id = '$_SESSION[pvp_battleid]'";

                        $result = $db->db_query($sql);

                        // take away HP
                        $sql = "UPDATE players
                                SET hp = '$newhp'
                                WHERE id = '$opp[id]'";

                        $result = $db->db_query($sql);

                        // set won session
                        $_SESSION['pvp_status'] = 'won';

                        // redirect
                        header("Location: index.php");
                        exit;
                }

                // take away HP
                $sql = "UPDATE players
                        SET hp = '$newhp'
                        WHERE id = '$opp[id]'";

                $result = $db->db_query($sql);

                // experience points from hitting this dude?
                if($dmg != 0)
                {
                        $exp_gain = abs(($dmg + $opp['level']) / ($user[10] / 4));
                        $new_exp = $user[12] + $exp_gain;

                        // update the db with new exp!
                        $sql = "UPDATE players
                                SET exp = '$new_exp'
                                WHERE name = '$_SESSION[usr_logged]'";

                        $result = $db->db_query($sql);

                        // is it time for a leveler uper?
                        if($new_exp >= ($user[10] . '00'))
                        {
                                $new_level = $user[10] + 1;

                                if($user[11] == "Warrior")
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

                                $msg .= '<b>You have leveled up!</b><br>';
                        }
                }
        }

                // update the last move time...
                $time = time();

                $sql = "UPDATE pvp
                                SET lastmove_time = '$time'
                                WHERE id = '$_SESSION[pvp_battleid]'";

                $result = $db->db_query($sql);

        return $msg;
}
//
// Function used in player vs. player battles
//
function pvp_battle()
{
        global $db, $fight_info, $user, $opp, $config;

        // find out who is the opponent
        $opponent_id = $fight_info['challenger'];
        if($opponent_id == $user['id'])
        {
                // it should NOT be the same as the user, so it must be
                // the other person...
                $opponent_id = $fight_info['defender'];
        }

        $sql = "SELECT * FROM players
                WHERE id = '$opponent_id'";

        $result = $db->db_query($sql);
        $opp = $db->db_fetch_array($result);

        // user HP graphs
        $hp_graph = makegraph($user[13], $user[14], 'HP: ', 'red');
        $mp_graph = makegraph($user[15], $user[16], 'MP: ', 'blue');

        // opponent graphs
        $opp_hp_graph = makegraph($opp[13], $opp[14], 'HP: ', 'red');
        $opp_mp_graph = makegraph($opp[15], $opp[16], 'MP: ', 'blue');

        //
        // Decide if the user is attacking or waiting, then act accordingly...
        //
        if($fight_info['lastmove_player'] == $user['id'])
        {
                                // check to make sure the user has not been idle for more then 2 minutes
                                $time = time();
                                if($time > ($fight_info['lastmove_time'] + 200))
                                {
                                        // they're out of time.
                                        $sql = "UPDATE pvp
                                                        SET won = '1', won_by = '$user[id]'";

                                        $result = $db->db_query($sql);

                                        // kill them :-)
                                        $sql = "UPDATE players
                                                        SET hp = '0'
                                                        WHERE id = '$opp[id]'";

                                        $result = $db->db_query($sql);

                                        // redirect to the index
                                        header("Location: index.php");
                                        exit;
                                }

                                // the user is waiting for the move so draw
                // out the wait page
                $extra = array(
                'user_image' => $user['char_img'],
                'user_hp' => $hp_graph,
                'user_mp' => $mp_graph,
                'opp_image' => $opp['char_img'],
                'opp_name' => $opp['name'],
                'opp_hp' => $opp_hp_graph,
                'opp_mp' => $opp_mp_graph,
                'messages' => $fight_info['messages'],
                'wait_message' => 'This window will refresh once every 5 seconds.');

                                $html = file_get_contents("templates/$config[template]/pvp_waiting.tpl");

                                $page = new Template();
                                $page->normalPage($html, $extra);
        }
        else
        {
                //
                // the user is attacking...
                //

                // has the user submitted an attack?
                if(isset($_POST['submit_attack']))
                {
                        // yes... now lets calculate the attack
                        $msg = calculate_attack();

                        // set them as the defender now...
                        $sql = "UPDATE pvp
                                SET lastmove_player = '$user[id]'
                                WHERE id = '$_SESSION[pvp_battleid]'";

                        $result = $db->db_query($sql);

                        // add the message about the status of the attack
                        $sql = "UPDATE pvp
                                SET messages = '$msg'
                                WHERE id = '$_SESSION[pvp_battleid]'";

                        $result = $db->db_query($sql);

                        // now refresh..
                        header("Location: pvp.php");
                        exit;

                }
                else
                {
                        // not submitted yet
                                                // see what is equipped
                                                if($user['equip1'] != 0)
                                                {
                                                        // something is equipped

                                                        // get it's info
                                                        $sql = "SELECT * FROM weapons
                                                                        WHERE id = '$user[equip1]'";

                                                        $result = $db->db_query($sql);
                                                        $row = $db->db_fetch_array($result);

                                                        $attack_options = "<option value=$user[equip1]>$row[name]</option>";
                                                }
                                                else
                                                {
                                                         // nothing equipped
                                                        $attack_options = '';
                                                }


                        $extra = array(
                        'user_image' => $user['char_img'],
                        'user_hp' => $hp_graph,
                        'user_mp' => $mp_graph,
                        'attack_opts' => $attack_options,
                        'opp_image' => $opp['char_img'],
                        'opp_name' => $opp['name'],
                        'opp_hp' => $opp_hp_graph,
                        'opp_mp' => $opp_mp_graph,
                        'messages' => $fight_info['messages']);

                        $html = file_get_contents("templates/$config[template]/pvp_attack.tpl");

                        $page = new Template();
                        $page->normalPage($html, $extra);
                }
        }
}
?>