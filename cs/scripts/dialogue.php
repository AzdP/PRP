<?php
if(!isset($_GET['act']))
{
        // list NPCs and see if they have dialogue attached to them...
        $list = '';

        $sql = "SELECT * FROM dialogue";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                $dialogue[$row[id]] = true;
        }

        $sql = "SELECT * FROM npc";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                $status = 'no dialogue';
                if(isset($dialogue[$row[id]]))
                {
                        $status = 'dialogue present';
                }

                $list .= "<tr><td>$row[name]</td><td>$status</td><td><a href=$src_file&act=edit&npc=$row[id]>edit</a></td></tr>";
        }

        // now parse the page
        $page = makepage('dialogue_list', '', 0);
        $page = str_replace('{list}', $list, $page);

        echo $page;
}
elseif($_GET['act'] == 'edit')
{
        if(isset($_GET['del']))
        {
                // update the npc topics and greeting
                $sql = "SELECT * FROM dialogue
                        WHERE npc_id = '$_GET[npc]'";

                $result = $db->db_query($sql);
                $row = $db->db_fetch_array($result);

                // delete a topic
                $dialogue_arr = explode('special', $row['dialogue']);
                $topics = explode(';', $dialogue_arr[1]);

                if(isset($topics[$_GET[del]]))
                {
                        $topic_arr = explode(':', $topics[$_GET[del]]);
                        $title = $topic_arr[0];
                        $text = $topic_arr[1];

                        $replace = "$title:$text;";

                        // replace it
                        $new_dialogue = str_replace($replace, '', $row['dialogue']);
                        $new_dialogue = addslashes($new_dialogue);

                        $sql = "UPDATE dialogue
                                SET dialogue = '$new_dialogue'
                                WHERE npc_id = '$_GET[npc]'";

                        $result = $db->db_query($sql);
                }
        }

        if(isset($_GET['update']) && isset($_GET['npc']))
        {
                // update the npc topics and greeting
                $sql = "SELECT * FROM dialogue
                        WHERE npc_id = '$_GET[npc]'";

                $result = $db->db_query($sql);
                $num = $db->db_num_rows($result);

                // first, get the greeting
                if($num > 0)
                {
                        $row = $db->db_fetch_array($result);
                        $dialogue_arr = explode('special', $row['dialogue']);

                        $greeting = trim($dialogue_arr[0]);
                }

                // now update the npc
                if($_POST['title'] != '' && $_POST['text'])
                {
                        $append = "\n$_POST[title]:$_POST[text];";
                }

                // check and see if there is already stuff in there
                if($num > 0 || $row['dialogue'] != '')
                {
                        $new_dialogue = str_replace($greeting, $_POST['greeting'], $row['dialogue']);
                        $new_dialogue .= $append;
                        $new_dialogue = addslashes($new_dialogue);

                        $sql = "UPDATE dialogue
                                SET dialogue = '$new_dialogue'
                                WHERE npc_id = '$_GET[npc]'";
                }
                else
                {
                        // we have to insert it
                        $new_dialogue = $_POST['greeting'] . "\n\nspecial\n" . $append;

                        $sql = "INSERT INTO dialogue
                                VALUES ('', '$_GET[npc]', '$new_dialogue')";
                }

                $result = $db->db_query($sql);

                echo '<b>Updated</b><br /><br />';
        }

        $sql = "SELECT * FROM dialogue
                WHERE npc_id = '$_GET[npc]'";

        $result = $db->db_query($sql);
        $row = $db->db_fetch_array($result);

        // first, get the greeting
        $dialogue_arr = explode('special', $row['dialogue']);

        $greeting = trim($dialogue_arr[0]);

        // get topics
        $topics = explode(';', $dialogue_arr[1]);
        foreach($topics as $key => $value)
        {
                $topic_arr = explode(':', $value);
                $title = $topic_arr[0];
                $text = $topic_arr[1];

                if(trim($title) == '' || trim($text) == '')
                {
                        continue;
                }

                $list .= "<tr><td>$title</td><td>$text</td><td><a href=$src_file&act=edit&del=$key&npc=$_GET[npc]>delete</a></tr>";
        }

        $page = makepage('dialogue_topics', '', 0);
        $page = str_replace('{greeting}', $greeting, $page);
        $page = str_replace('{list}', $list, $page);
        $page = str_replace('{npc}', $_GET['npc'], $page);

        echo $page;
        exit;
}
?>
