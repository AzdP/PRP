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
include_once("includes/startup.php");

if(!isset($npc[1]))
{
        // get info about this npc
        $sql = "SELECT * FROM npc
                WHERE id = '$_GET[npc]'";

        $result = $db->db_query($sql);
        $npc = $db->db_fetch_array($result);
}
else
{
        $inc = 1;
}

// make sure this npc has a quest assigned to him/her
$sql = "SELECT * FROM quests
        WHERE given_by = '$npc[id]'";

$result = $db->db_query($sql);
$num = $db->db_num_rows($result);

if($num == 0)
{
        // no? well is this the person that is the recepiant of the quest?
        $sql = "SELECT * FROM quests
                WHERE npc_target = '$npc[id]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num == 0)
        {
                // no?! this user is trying to hack or something... lets spit out a cryptic message!
                die("Critical error");
        }

        // Okee dokie, this NPC is the recepiant of a quest
        $quest = $db->db_fetch_array($result);

        // get an array for the status of the quest
        $sql = "SELECT * FROM quest_status
                WHERE qid = '$quest[0]' AND pid = '$user[0]'";

        $result = $db->db_query($sql);
        $quest_status = $db->db_fetch_array($result);

        // is the quest already completed?
        if($quest_status['status'] == 'complete')
        {
                include("templates/$config[template]/simple_header.tpl");
                echo 'Hacking attempt!';
                include("templates/$config[template]/simple_footer.tpl");
                exit;
        }

        // first we need to check if the user has the appropriate item for the quest to be completed
        $sql = "SELECT * FROM inventory
                WHERE item_id = '$quest[item_to_find]'";

        $db->db_query($sql);
        $num = $db->db_num_rows($result);

        // now, do we need to spit out normal dialogue or is the quest completed?
        if($num > 0)
        {
                // quest is complete.

                // now lets first remove the item from the inventory, give
                // the reward, and mark the quest as completed.
                $sql = "DELETE FROM inventory
                        WHERE item_id = '$quest[7]'
                        AND pid = '$user[0]'";

                $result = $db->db_query($sql);

                // determine reward...
                $pieces = explode(' ', $quest[5]);
                if($pieces[0] == "GOLD")
                {
                        // the reward is some gold
                        $new_gold = $user[17] + $pieces[1];

                        // update with the new gold in the database
                        $sql = "UPDATE players
                                SET gold = '$new_gold'
                                WHERE id = '$user[0]'";

                        $result = $db->db_query($sql);
                }

                if($pieces[0] == "ITEM")
                {
                        // insert the item
                        $sql = "INSERT INTO inventory (pid,type,itemid,quantity)
                                VALUES ('$user[0]', 'weapon', '$pieces[1]', '1')";

                        $result = $db->db_query($sql);
                }

                // mark the quest as complete
                $sql = "UPDATE quest_status
                        SET status = 'complete'
                        WHERE qid = '$quest[0]'
                        AND pid = '$user[0]'";

                $result = $db->db_query($sql);

                // spit out the quest complete dialogue
                include("templates/$config[template]/simple_header.tpl");
                echo "<b>$npc[1]</b><br>";
                echo str_replace("\n", "\n<br>", $quest[13]);
                echo '<br /><br /><i>Your journal has been updated</i>';
                include("templates/$config[template]/simple_footer.tpl");
                exit;
        }

        // otherwise we just continue and spit out normal dialogue
}
elseif(!isset($inc))
{
        // ok, this npc needs to assign the quest. first lets get info about this quest...
        $quest = $db->db_fetch_array($result);

        // now we'll check the status... is this quest already assigned? is it complete? incomplete?
        $sql = "SELECT * FROM quest_status
                WHERE pid = '$user[0]'
                AND qid = '$quest[0]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        // check if it's already assigned
        if($num == 0)
        {
                // need to assign the quest
                $sql = "INSERT INTO quest_status
                        VALUES('','$user[0]','$quest[0]','incomplete')";

                $result = $db->db_query($sql);
                /*
                // Add the item
                $sql = "INSERT INTO inventory
                        VALUES('$user[id]', 'item', '$quest[give_item]', '1')";

                $result = $db->db_query($sql);
                */

                // spit out dialogue accordingly
                include("templates/$config[template]/simple_header.tpl");
                echo "<b>$npc[name]</b><br>";
                echo str_replace("\n", "\n<br>", $quest[10]);
                echo '<br /><br /><i>Your journal has been updated</i>';
                include("templates/$config[template]/simple_footer.tpl");
                exit;
        }
        else
        {
                // need to check if its incomplete or complete, then spit out dialogue accordingly
                $quest_status = mysql_fetch_array($result);

                if($quest_status[3] == "complete")
                {
                        // spit out the complete dialogue
                        include("templates/$config[template]/simple_header.tpl");
                        echo "<b>$npc[name]</b><br>";
                        echo str_replace("\n", "\n<br>", $quest[11]);
                        include("templates/$config[template]/simple_footer.tpl");
                        exit;
                }
                elseif($quest_status[3] == "incomplete")
                {
                        // spit out the incomplete dialogue
                        include("templates/$config[template]/simple_header.tpl");
                        echo "<b>$npc[name]</b><br>";
                        echo str_replace("\n", "\n<br>", $quest[12]);
                        include("templates/$config[template]/simple_footer.tpl");
                        exit;
                }
        }
}
?>
