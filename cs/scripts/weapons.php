<?php
if(!isset($_GET['act']))
{
        // list weapons
        $wep_list = '';
        $sql = "SELECT * FROM weapons";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                // display a list
                $wep_list .= "<tr><td><img src=\"../images/weapons/$row[image].gif\"> $row[name]</td><td>$row[min_damage] - $row[max_damage]</td><td>$row[value]</td><td><a href=$src_file&act=edit&wid=$row[id]>Edit</a> - <a href=$src_file&act=del&wid=$row[id]>Delete</a></tr>";
        }

        // draw page
        $page = makepage('weapon_list', '', 0);
        $page = str_replace('{list}', $wep_list, $page);

        echo $page;
}
elseif($_GET['act'] == 'add')
{
        if(!isset($_POST['submit']))
        {
                // draw form
                makepage('weapon_add');
        }
        else
        {
                $sql = "INSERT INTO weapons (id, name, min_damage, max_damage, image, value)
                        VALUES ('', '$_POST[name]', '$_POST[min_damage]', '$_POST[max_damage]', '$_POST[image]', '$_POST[value]')";

                $result = $db->db_query($sql);

                makepage('weapon_add_success');
        }
}
elseif($_GET['act'] == 'del')
{
        if(!isset($_GET['wid']))
        {
                die('error');
        }

        $sql = "DELETE FROM weapons
                WHERE id = '$_GET[wid]'";

        $result = $db->db_query($sql);

        makepage('weapon_deleted');
}
elseif($_GET['act'] == 'image')
{
        // get a list of images
        $list = '';
        $dh = opendir('../images/weapons/');
        while($file = readdir($dh))
        {
                if($file == '.' || $file == '..')
                {
                        continue;
                }

                $pos = strpos($file, '.');
                $fileNoExt = substr($file, 0, $pos);

                $list .= "<option value=\"$fileNoExt\">$file</option>\n";
                $lastFile = $file;
        }
        $page = makepage('weapon_image', '', 0);
        $page = str_replace('{list}', $list, $page);
        $page = str_replace('{initialimage}', "../images/weapons/$lastFile", $page);

        echo $page;
        exit;
}
elseif($_GET['act'] == 'edit')
{
        if(!isset($_POST['submit']))
        {
                $sql = "SELECT * FROM weapons
                        WHERE id = '$_GET[wid]'";

                $result = $db->db_query($sql);
                $row = $db->db_fetch_array($result);

                $page = makepage('weapon_edit', '', 0);
                $page = str_replace('{name}', $row['name'], $page);
                $page = str_replace('{image}', $row['image'], $page);
                $page = str_replace('{mindmg}', $row['min_damage'], $page);
                $page = str_replace('{maxdmg}', $row['max_damage'], $page);
                $page = str_replace('{value}', $row['value'], $page);
                $page = str_replace('{wid}', $row['id'], $page);

                echo $page;
        }
        else
        {
                // update
                $sql = "UPDATE weapons
                        SET name = '$_POST[name]', image = '$_POST[image]', min_damage = '$_POST[min_damage]', max_damage = '$_POST[max_damage]', value = '$_POST[value]'
                        WHERE id = '$_GET[wid]'";

                $result = $db->db_query($sql);

                makepage('weapon_edited');
        }
}

?>

