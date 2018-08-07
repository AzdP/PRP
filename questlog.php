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

// grab a list of all quests
$sql = "SELECT * FROM quests";
$result = $db->db_query($sql);
while($row = $db->db_fetch_array($result))
{
        $quest[$row[0]][1] = $row[1];
        $quest[$row[0]][2] = $row[2];
}

$sql = "SELECT * FROM quest_status
        WHERE pid = '$user[0]'
        ORDER BY id DESC";

$result = $db->db_query($sql);
$num = $db->db_num_rows($result);

if($num == 0)
{
        $quests = "<center>You currently have no quests logged!</center>";
}
else
{
        $quests = "";
        while($row = $db->db_fetch_array($result))
        {
                $quests .= "<b>".$quest[$row[2]][1]."</b> ($row[3])<br />";
                $quests .= $quest[$row[2]][2]."<br /><br />";
        }
}

$page = new Template();

$page->set_files(array(
'header' => '',
'body' => 'questlog_body.tpl',
'footer' => ''));

$page->assign_vars(array(
'quests' => $quests));

$page->ppage();
?>
