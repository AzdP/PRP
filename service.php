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

if($_GET['service'] == 'heal')
{
        // get info about the npc giving the healing
        $sql = "SELECT * FROM npc
                WHERE id = '$_GET[nid]'";

        $result = $db->db_query($sql);
        $npc = $db->db_fetch_array($result);

        // calculate how much should be charged
        $new_gold = $user[17] - (round( ($user[14] - $user[13]) / 2 ));

        // do they have enough $$?
        if(strstr($new_gold, "-"))
        {
                // they dont! kick them out!
                header("Location: dialogue.php?npc=$npc[id]&spec=heal2");
                exit;
        }

        // update the user information. make sure to compare the
        // user sector to the npc sector! This will prevent cheating by
        // just going to the url...
        $sql = "UPDATE players
                SET hp = '$user[14]', gold = '$new_gold'
                WHERE sector = '$npc[sector_id]'
                AND name = '$_SESSION[usr_logged]'";

        $result = $db->db_query($sql);

        // send them back to the dialogue
        header("Location: dialogue.php?npc=$npc[id]&spec=heal");
        exit;
}
elseif($_GET['service'] == 'barter')
{
        if(!isset($_GET['buy']))
        {
                // get info about the npc
                $sql = "SELECT * FROM npc
                        WHERE id = '$_GET[nid]'";

                $result = $db->db_query($sql);
                $npc = $db->db_fetch_array($result);

                // make sure the npc even offers bartering...
                if(!strstr($npc['services'], 'barter'))
                {
                        // Not a merchent
                        die("This NPC is not a merchent!");
                }

                // include the simple header
                $output = $lang['buy_instruct'] . '<br \><br \>';
                $output .= '<b>' . $lang['weapons'] . ':</b><br />';

                // list weapons this npc offers
                $wepList = explode(',', $npc['weapons']);
                foreach($wepList as $value)
                {

                        $sql = "SELECT * FROM weapons
                                        WHERE id = '$value'";

                        $result = $db->db_query($sql);
                        $row = $db->db_fetch_array($result);

                        $output .= '<a href="service.php?service=barter&nid='.$_GET['nid'].'&buy='.$row[0].'&type=weapon">'.$row[1].'</a> - '.$row[6].'G<br>';
                }

                $output .= '<br /><br /><b>Items:</b><br />';
                // list the items this npc offers
                if(strstr($npc['items'], ','))
                {
                        // more then 1 item
                        $items = explode(',', $npc['items']);
                        foreach($items as $value)
                        {
                                $sql = "SELECT * FROM items WHERE id = '$value'";
                                $result = $db->db_query($sql);

                                $row = $db->db_fetch_array($result);

                                $output .= '<a href="service.php?service=barter&nid=' . $_GET['nid'] . '&type=item&buy=' . $row['id'] . '">' . $row['name'] . '</a> - ' . $row['value'] . 'G<br>';
                        }
                }
                else
                {
                        // only one item
                        $sql = "SELECT * FROM items WHERE id = '$npc[items]'";
                        $result = $db->db_query($sql);

                        $row = $db->db_fetch_array($result);

                        $output .= '<a href="service.php?service=barter&nid='.$_GET['nid'].'&buy='.$row[0].'&type=item">'.$row[1].'</a> - '.$row['value'].'G<br>';
                }

                // back link
                $output .= '<br><br><center><a href="dialogue.php?npc='.$_GET['nid'].'">Back</a></center>';

                $page = new Template();
                $page->simplePage($output);
        }
        else
        {
                if($_GET['type'] == 'weapon')
                {
                        $player->addWeapon($_GET['buy']);
                }
                else if($_GET['type'] == 'item')
                {
                        $player->addItem($_GET['buy']);
                }

                $page = new Template();
                $page->simplePage('Item purchased.<br /><br /><center><a href="dialogue.php?npc='.$_GET['nid'].'">Back</a></center>');

                //--------------------------------
                // Finished
        }
}
?>
