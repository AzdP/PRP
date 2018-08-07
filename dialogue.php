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

if(!isset($_GET['npc']))
{
        echo '<html></html>';
        exit;
}
else
{
        require("includes/startup.php");

        $sql = "SELECT * FROM dialogue
                WHERE npc_id = '$_GET[npc]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        // no such NPC!
        if($num == 0)
        {
                die("Invalid NPC");
        }

        $dialogue = $db->db_fetch_array($result);

        $sql = "SELECT * FROM npc
                WHERE id = '$_GET[npc]'";

        $result = $db->db_query($sql);

        $npc = $db->db_fetch_array($result);

        if(isset($_GET['left']))
        {
                //
                // we need to display topics that the user can ask the NPC
                // plus we need to list services
                //

                $output = '';

                // what services does this NPC offer?
                if(strstr($npc['services'], 'barter'))
                {
                        $output .= '<a href="service.php?service=barter&nid='.$_GET['npc'].'" target=text>Barter</a><br />';
                }

                if(strstr($npc['services'], 'heal'))
                {
                        $output .= '<a href="service.php?nid='.$_GET['npc'].'&service=heal" target=text>Heal</a><br />';
                }

                if($output != '')
                {
                        $output .= '<hr width="100%" height="1" color="000000" align="left">';
                }

                // now we list the rest of the stuff the npc can talk about
                if(strstr($dialogue['dialogue'], 'special'))
                {
                        $topics = explode('special', $dialogue['dialogue']);
                        $topics = explode(';', $topics[1]);

                        foreach($topics as $key => $value)
                        {
                                $arr = explode(':', $value);

                                $output .= "<a href=\"dialogue.php?npc=$_GET[npc]&topic=$key\" target=text>" . $arr[0] . '</a><br />';
                        }

                }
                else
                {
                        $output .= 'No Topics';
                }

echo <<<html
<html>
<head>
<title>MMORPG</title>
<style>
<!--
td,body           { font-family: Verdana; font-size: 10px }
-->
</style>
<body>
$output
</body>
</html>
html;

                //exit the script b/c the rest is for the right frame!
                exit;
        }

        if(isset($_GET['spec']))
        {
                if($_GET['spec'] == 'heal')
                {
                        $say = 'You have been healed!<br />';
                        //$say .= '<a href="#" onClick="parent.closeit()">Goodbye</a>';
                }
                else
                {
                        $say = 'Sorry, you cannot afford this!<br />';
                        //$say .= '<a href="#" onClick="parent.closeit()">Goodbye</a>';
                }
        }
        else
        {
                $topics = explode('special', $dialogue['dialogue']);
                if(!isset($_GET['topic']))
                {
                        $say = $topics[0];

                        // parse this for quest links
                        $say = eregi_replace("\\{questLink\\}([^\\[]*)\\{/questLink\\}","<a href=\"quest.php?npc=$_GET[npc]\">\\1</a>",$say);
                }
                else
                {
                        $topics = explode(';', $topics[1]);

                        foreach($topics as $key => $value)
                        {
                                if($key == $_GET['topic'])
                                {
                                        $arr = explode(':', $value);
                                        $say = $arr[1];
                                }
                        }
                }
        }

        //
        // lets do this special stuff for quests...
        // first we see if the npc is the recevier of any quests then we
        // include the quest file to deal with that
        //
        $sql = "SELECT * FROM quests
                WHERE npc_target = '$npc[id]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        // include quests file if he is
        if($num > 0)
        {
                $row = $db->db_fetch_array($result);

                // now lets make sure this quest isn't already completed
                $sql = "SELECT * FROM quest_status
                        WHERE pid = '$user[0]' AND qid = '$row[0]' AND status != 'complete'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);

                if($num > 0)
                {
                        // ok... this npc is a reciever of a quest and this quest has not
                        // already been completed by the player
                        include("quest.php");
                }
        }
}

$say = stripslashes($say);
?>
<html>
<head>
<title>MMORPG</title>
<style>
<!--
td,body           { font-family: Verdana; font-size: 10px }
-->
</style>
<body>
<?php
echo "<b>$npc[1]</b><br />";
echo $say;
?>
</body>
</html>
