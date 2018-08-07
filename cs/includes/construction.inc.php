<?php
//
// This is the main class for all the editor's functions
// and utilities
//
class Editor
{
        // DrawSector() function documentation
        // ---------------------------------
        // This function is a stripped down version of the drawsector()
        // function used in the actual script made for the editor. The main
        // difference is that it gets all the object data real time instead
        // of from the cache files that are stored in the system. This way
        // the user/script wont have to update the files every time a change is
        // made.
        //
        function drawsector()
        {
              global $sector, $config, $u_x, $u_y, $db, $xoffset, $yoffset;

              //
              // since this is the editor we need to store temporary position
              // variables and stuff in sessions, for now we'll put them
              // into nice little variables
              //
              $editor['x'] = $_SESSION['ed_x'];
              $editor['y'] = $_SESSION['ed_y'];
              $editor['sector'] = $_SESSION['ed_sector'];

              // build the html to display the users cursor in the editor
              //$div_style = '#cursor { LEFT: '.($editor[x] + $xoffset).'px; VISIBILITY: visible; POSITION: absolute; TOP: '.($u_y + $yoffset).'px; Z-index: 100; }';
              $div_html = '<div style="LEFT: '.($editor['x'] + $xoffset).'px; VISIBILITY: visible; POSITION: absolute; TOP: '.($editor['y'] + $yoffset).'px; Z-index: 200;"><img src=images/cursor.gif alt="Cursor"></div>';

              //gen div tags for objects
              $sql = "SELECT * FROM terrain
                      WHERE sector_id = '$editor[sector]'";

              $result = $db->db_query($sql);
              while($row = $db->db_fetch_array($result))
              {
                      if($row[4] == 0)
                      {
                              $layer = 'Z-index: 2;';
                      }
                      else
                      {
                              $layer = 'Z-index: 101;';
                      }

                      if(strstr($row[3], '.'))
                      {
                              $ext = '';
                      }
                      else
                      {
                              $ext = '.gif';
                      }

                                        // add it to the object index
                                        $objIndex[$row[5] . ':' . $row[6]] = $row[0];

                      $div_style .= "#$row[0]terr { LEFT: ".($row[5] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[6] + $yoffset)."px; $layer}\n";
                      $div_html .= "<div style=\"LEFT: ".($row[5] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[6] + $yoffset)."px; $layer\"><a href=\"index.php?x=$row[5]&y=$row[6]\"><img src=../images/obj/$row[3]$ext alt=\"$row[2]\" border=0></a></div>\n";
              }

              //gen div tags for buildings
              $sql = "SELECT * FROM buildings
                      WHERE sector_id = '$editor[sector]'";

              $result = $db->db_query($sql);
              while($row = $db->db_fetch_array($result))
              {
                      $ext = '';
                      if(!strstr($row['image'], '.'))
                      {
                              $ext = '.gif';
                      }

                      // add it to the object index
                      $buildIndex[$row['x'] . ':' . $row['y']] = $row[id];

                      $div_style .= "#$row[0]build { LEFT: ".($row[3] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[4] + $yoffset)."px; Z-index: 2; }\n";
                      $div_html .= "<div style=\"LEFT: ".($row[3] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[4] + $yoffset)."px; Z-index: 2;\"><a href=\"\" onClick=\"window.open('module.php?mid=changesector&sector=$row[interior]&close=1', 'change_sector', 'directories=no,height=200,width=400,location=no,resizable=yes,status=no,titlebar=no,toolbar=no')\"><img src=../images/buildings/$row[5]$ext alt=\"$row[1] ($row[x], $row[y])\" border=0></a></div>\n";
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
                      WHERE sector = '$editor[sector]'
                      AND killed = '0'";

              $result = $db->db_query($sql);
              $numrows = $db->db_num_rows($result);
              while(($row = $db->db_fetch_array($result)) && ($num < $numrows))
              {
                      //$div_style .= "#".$monsters[$rand][0]."monster {  }\n";
                      $div_html .= "<div style=\"LEFT: ".($row[3] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[4] + $yoffset)."px; Z-index: 3;\"><img src=images/monsters/".$monsters[$rand][2].".gif alt=\"".$monsters[$rand][1]."\"></div>\n";
                      $num++;
              }

        // generate div tags for npcs
        $sql = "SELECT * FROM npc
                WHERE sector_id = '$_SESSION[ed_sector]'";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
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

                // add them to the index
                $npcIndex[$xpos . ':' . $ypos] = $row['id'];

                $div_html .= "<div style=\"LEFT: ".($xpos + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($ypos + $yoffset)."px; Z-index: 30;\"><img src=../images/npc/$row[2].gif alt=\"$row[1] (NPC)\" border=\"0\"></div>\n";
        }

              // display clipping?
              if($_SESSION['ed_clipping'])
              {
                      // yes, display the clipping
                      $sql = "SELECT * FROM clipping
                              WHERE sector_id = '$_SESSION[ed_sector]'";

                      $result = $db->db_query($sql);
                      while($row = $db->db_fetch_array($result))
                      {
                              $div_html .= "<div style=\"LEFT: ".($row[x] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[y] + $yoffset)."px; Z-index: 30;\"><img src=images/clipping.gif style=\"filter:alpha(opacity=30); moz-opacity:0.3;\"></div>\n";
                      }
              }

              // start html proper
              $output['div_style'] = $div_style;
              $output['html'] = $div_html;
              $output['html'] .= '<table width="402" height="402" border="1" bordercolor="000000" background="../images/background/' . $sector[2] . '.gif">';

              // fill in dat table bro!
              $output['html'] .= '<tr><td></td></tr>';

              // end html proper
              $output['html'] .= '</table>';

              // build indexes
              $output['objIndex'] = $objIndex;
              $output['buildIndex'] = $buildIndex;
              $output['npcIndex'] = $npcIndex;

              return $output;
      }
}