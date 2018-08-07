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

//
// Sector Functions
//
function drawsector()
{
        global $user, $sector, $config, $_GET, $u_x, $u_y, $db, $xoffset, $yoffset;

        $div_style = '';

        $output['talk'] = '';
        $output['fight'] = '';

        $div_html = "<div style=\"LEFT: ".($u_x + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($u_y + $yoffset)."px; Z-index: 100;\"><b>$user[name]</b><br><img src=images/pc/".$user[6].".gif alt=\"".$user[1]."\"></div>";

        // generate layers
        $query = mysql_query("SELECT * FROM online");
        while($row = mysql_fetch_array($query))    {
                $online[$row[1]] = 1;
        }

        $query = mysql_query("SELECT * FROM players WHERE sector = '$user[7]' AND name != '$user[1]'") or die(mysql_error());
        while($row = mysql_fetch_array($query))
        {
                if(isset($online[$row[1]]))
                {
                        if($row[8] > 350)
                        {
                                $row[8] = 350;
                        }

                        if($row[9] > 350)
                        {
                                $row[9] = 350;
                        }

                        $div_html .= "<div style=\"LEFT: ".($row[8] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[9] + $yoffset)."px; Z-index: 100;\"><b>$row[name]</b><br><a href=pvp.php?fight=$row[id]><img src=images/pc/$row[char_img].gif alt=\"$row[name]\" border=0></a></div>\n";
                }
        }

        //gen div tags for monsters
        $num = 0;
        $sql = "SELECT * FROM monsters";

        $result = $db->db_query($sql);
        while($monsters[$num] = $db->db_fetch_array($result))
        {
                $num++;
        }

        $sql = "SELECT * FROM monster_pos
                        WHERE sector = '$user[7]'
                        AND killed = '0'";

        $result = $db->db_query($sql);
        $numrows = $db->db_num_rows($result);
        $num = 0;
        $num_aval = count($monsters) - 2; // number of monsters available minus 2 because we need to randomize it... the actual number would not WORK
        while(($row = $db->db_fetch_array($result)) && ($num < $numrows))
        {
                // pick a monster, any monster!
                $rand = $row[1];

                if((abs($row[4] - $u_y) == 50) && ($u_x == $row[3]))
                {
                        $output['fight'] = $monsters[$rand][0];
                }

                if((abs($row[3] - $u_x) == 50) && ($u_y == $row[4]))
                {
                        $output['fight'] = $monsters[$rand][0];
                }

                $_SESSION['valid_monsters'] .= $monsters[$rand]['id'];

                $div_html .= "<div style=\"LEFT: ".($row[3] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[4] + $yoffset)."px; Z-index: 3;\"><img src=images/monsters/".$monsters[$rand][2].".gif alt=\"".$monsters[$rand][1]."\"></div>\n";
                $num++;
        }

        // generate div tags for npcs
        $sql = "SELECT * FROM npc
                WHERE sector_id = '$user[sector]'";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                if((abs($row['y'] - $u_y) == 50) && ($u_x == $row['x']))
                {
                        $output['talk'] = $row[0];
                }

                if((abs($row['x'] - $u_x) == 50) && ($u_y == $row['y']))
                {
                        $output['talk'] = $row[0];
                }

                // set x and y to default
                $xpos = $row['x'];
                $ypos = $row['y'];

                // does this npc move around on the X-plane?
                if(strstr($row['x'], ','))
                {
                        // select a position
                        $positions = explode(',', $row['x']);
                        $num = count($positions) - 1;
                        $pos_id = rand(0, $num);

                        $xpos = $positions[$pos_id];
                }

                // does this npc move around on the Y-plane?
                if(strstr($row['y'], ','))
                {
                        // select a position
                        $positions = explode(',', $row['y']);
                        $num = count($positions) - 1;
                        $pos_id = rand(0, $num);

                        $ypos = $positions[$pos_id];
                }

                $div_html .= "<div style=\"LEFT: ".($xpos + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($ypos + $yoffset)."px; Z-index: 30;\"><a href=# onClick=\"javascript:loadwindow('talk.php?npc=$row[id]',600,400)\"><img src=images/npc/$row[2].gif alt=\"$row[1] (NPC)\" border=\"0\"></a></div>\n";
        }

        // start html proper
        $output['html'] = $div_html;
        $output['html'] .= '<table width="402" height="402" border="1" bordercolor="000000" background="' . $config['img_url'] . '/background/' . $sector[2] . '.gif">';

        // fill in dat table bro!
        $output['html'] .= '<tr><td></td></tr>';

        // end html proper
        $output['html'] .= '</table>';

        return $output;
}

function makegraph($value, $max, $title, $color)
{
        global $config;

        $path = "templates/$config[template]/images/";

        $foo = (100 / $max);
        $color_width = ($value * $foo);
        $white_width = (100 - $color_width);

        $output = $title;
        $output .= '<img border="0" src="' . $path . 'bar_' . $color . '.gif" width="' . $color_width . '" height="6" alt="' . $value . '/' . $max . '">';
        $output .= '<img border="0" src="' . $path . 'bar_white.gif" width="' . $white_width . '" height="6" alt="'.$value.'/'.$max.'">';

        return $output;
}

function online_list()
{
        global $online, $user, $lang;

        $list = '';
        foreach($online as $name => $true)
        {
                // only parse through if it isnt the user requesting the data
                if($name != $user['name'])
                {
                        $list .= "<a href=\"view_profile.php?id=$name\">$name</a><br />";
                }
        }

        // make sure it aint empty
        if($list == '')
        {
                $list = $lang['none_online'];
        }

        return $list;
}

function attach_debug()
{
        global $pagetime1, $num_queries;

        // now lets calculate page load!
        $pagetime2 = microtime();
        $pgtime = $pagetime2 - $pagetime1;

        echo "\n\n<!--\n Generation Time: $pgtime seconds\n Queries: $num_queries\n-->";
}

function clean_inputs()
{
        // clean the post variables
        foreach($_POST as $key => $value)
        {
                $value = trim($value);
                $value = addslashes($value);
                $_POST[$key] = $value;
        }
}

function make_map()
{
        global $db;

        // get info on first sector
        $sql = "SELECT id,bg,left_tele,right_tele,top_tele,bot_tele FROM sectors
                WHERE id = '1'";

        $result = $db->db_query($sql);
        $cur = $db->db_fetch_array($result);
        $row[0][0] = "<td background=images/bgs/$cur[bg].gif height=10 width=10></td>";
        $cur_num = -1;
        // generate as far left as possible
        while($cur['left_tele'] != '')
        {
                $sql = "SELECT * FROM sectors
                        WHERE id = '$cur[left_tele]'";

                  $result = $db->db_query($sql);
                  $cur = $db->db_fetch_array($result);

                $row[0][$cur_num] = "<td background=images/bgs/$cur[bg].gif height=10 width=10></td>";

                $cur_num--;
        }

        // put it together
        echo "<table><tr>";
        foreach($row[0] as $key => $value)
        {
                echo $value;
        }
        echo "</tr></table>";
}
?>