<?php
//
// Make NPC Script
//

if(isset($_GET['sel']))
{
        // tryin to select an image or something
        if($_GET['sel'] == 'image')
        {
                // select an npc image
                $dir = '../images/npc/';
                $dh = opendir($dir);

                $img_list = '';
                while($file = readdir($dh))
                {
                        if($file == '.' || $file == '..')
                        {
                                continue;
                        }

                        $pos = strpos($file, '.');
                        $fileNoExt = substr($file, 0, $pos);

                        $img_list .= '<option value='.$fileNoExt.'>'.$fileNoExt.'</option>';
                        $lastFile = $file;
                }

                $page = makepage('npc_image', '', 0);
                $page = str_replace('{list}', $img_list, $page);
                $page = str_replace('{initialimage}', "../images/npc/$lastFile", $page);

                echo $page;
                exit;
        }
}



if(!isset($_POST['submit']))
{
        // draw out form
        makepage('npc_form');
}
else if($_POST['submit'] == 'Step 2' && $_POST['barter'] == 'on')
{
        // check form input
        $filled_out = check_post(array('name', 'image', 'barter'));

        if($filled_out == FALSE)
        {
                // redirect to origonal form
                echo "Invalid";
                exit;
        }

        // clean up all post variables
        clean_inputs();

        // get a list of inputs already specified
        $inputs = '<input type="hidden" name="name" value="'.$_POST['name'].'">';
        $inputs .= '<input type="hidden" name="image" value="'.$_POST['image'].'">';
        $inputs .= '<input type="hidden" name="barter" value="'.$_POST['barter'].'">';
        $inputs .= '<input type="hidden" name="heal" value="'.$_POST['heal'].'">';
        $inputs .= '<input type="hidden" name="heal" value="'.$_POST['move_around'].'">';

        $sql = "SELECT * FROM weapons";

        $result = $db->db_query($sql);
        $wep_list = '';
        while($row = $db->db_fetch_array($result))
        {
                $wep_list .= "<tr><td><img src=../images/weapons/$row[image].gif></td><td>$row[name]</td><td>$row[min_damage]/$row[max_damage]</td><td>$row[value]</td><td><input type=checkbox name=wep_$row[id]></td></tr>";
        }

        // display a successful message
        $page = makepage('npc_weapons', '', 0);
        $page = str_replace('{wep_list}', $wep_list, $page);
        $page = str_replace('{inputs}', $inputs, $page);

        echo $page;
}
else if($_POST['submit'] == 'Step 3' && $_POST['barter'] == 'on')
{
        // get a list of items
        $sql = "SELECT * FROM items";

        $result = $db->db_query($sql);
        $item_list = '';
        while($row = $db->db_fetch_array($result))
        {
                $item_list .= "<tr><td><img src=../images/items/$row[image].gif></td><td>$row[name]</td><td>$row[effect_type] ($row[effect]/$row[effect_cap])</td><td>$row[value]</td><td><input type=checkbox name=item_$row[id]></td></tr>";
        }

        // pass all inputs
        $inputs = '';
        foreach($_POST as $key => $value)
        {
                $inputs .= "<input type=\"hidden\" name=\"$key\" value=\"$value\">";
        }

        // make all post data so it can be passed through...
        $page = makepage('npc_items', '', 0);
        $page = str_replace('{item_list}', $item_list, $page);
        $page = str_replace('{inputs}', $inputs, $page);

        echo $page;
}
else
{
        // determine services
        $services = '';
        if($_POST['barter'] == 'on')
        {
                $services .= 'barter';
                $comma = ',';
        }

        if($_POST['heal'] == 'on')
        {
                $services .= $comma . 'heal';
        }

        $wep_comma = '';
        $item_comma = '';

        // make item/weapon lists
        foreach($_POST as $key => $value)
        {
                if(strstr($key, 'wep_') && $_POST[$key] == 'on')
                {
                        // get the id
                        $pos = strpos($key, '_');
                        $wep_id = substr($key, $pos);

                        // add the wep to the list
                        $wep_list .= $wep_comma . $wep_id;
                }
                else if(strstr($key, 'item_') && $_POST[$key] == 'on')
                {
                        // get the id
                        $pos = strpos($key, '_');
                        $item_id = substr($key, $pos);

                        // add to item list
                        $item_list .= $item_comma . $item_id;
                }

                // set the comma for entrees after if the first
                $wep_comma = ',';
                $item_comma = ',';
        }
        $x_pos = $_SESSION['ed_x'];
        $y_pos = $_SESSION['ed_y'];
        // move around?
        if($_POST['move_around'] == 'on')
        {
                $x_pos .= ',' . ($x_pos - 5) . ',' . ($x_pos + 10);
                $y_pos .= ',' . ($y_pos - 5) . ',' . ($y_pos + 10);
        }

        // put it into the db
        $sql = "INSERT INTO npc
                VALUES ('', '$_POST[name]', '$_POST[image]', '$_SESSION[ed_sector]', '$_SESSION[ed_x]', '$_SESSION[ed_y]', '$services', '$wep_list', '$item_list')";

        $result = $db->db_query($sql);

        makePage('npc_added');
}
?>
