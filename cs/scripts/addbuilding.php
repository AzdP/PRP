<?php
if(isset($_GET['selimg']))
{
        // get a list of images
        $list = '';
        $dh = opendir('../images/buildings/');
        while($file = readdir($dh))
        {
                if($file == '.' || $file == '..')
                {
                        continue;
                }

                $list .= "<option value=\"$file\">$file</option>\n";
                $lastFile = $file;
        }
        $page = makepage('building_image', '', 0);
        $page = str_replace('{list}', $list, $page);
        $page = str_replace('{initialimage}', "../images/buildings/$lastFile", $page);


        echo $page;
        exit;
}

if(!isset($_POST['submit']) && !isset($_POST['final']))
{
        // grab a list of sectors
        $sector_list = '';
        $sql = "SELECT * FROM sectors";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                $sector_list .= "<option value=$row[id]>$row[name]</option>";
        }

        // draw out form
        $page = makePage('new_building', '', 0);
        $page = str_replace('{sector_list}', $sector_list, $page);

        echo $page;
}
else if(isset($_POST['submit']))
{
        //
        // calculate the rows/columns needed for this image
        //

        // first get width/height
        $image_path = "../images/buildings/$_POST[image]";
        list($width, $height) = getimagesize($image_path);

        $num_rows = $height / 50;
        $num_cols = $width / 50;

        $table = '';
        for($rows = 0; $rows < $num_rows; $rows++)
        {
                $table .= '<tr>';
                for($cols = 0; $cols < $num_cols; $cols++)
                {
                        $x = (50 * $cols) + $_SESSION['ed_x'];
                        $y = (50 * $rows) + $_SESSION['ed_y'] - 50;
                        $value = "$x,$y";

                        $table .= '<td width="50"><input type="radio" name="door" value="'.$value.'"></td>' . "\n";
                }
                $table .= '<tr>';
        }

        $inputs = "<input type=hidden name=name value=$_POST[name]><input type=hidden name=image value=$_POST[image]><input type=hidden name=sector value=$_POST[sector]>";

        $page = makePage('new_building2', '', 0);
        $page = str_replace('{width}', $width, $page);
        $page = str_replace('{height}', $height, $page);
        $page = str_replace('{bg}', $image_path, $page);
        $page = str_replace('{inputs}', $inputs, $page);
        $page = str_replace('{inside}', $table, $page);

        echo $page;
}
else if(isset($_POST['final']))
{
        // add it!
        $door_pos = explode(',', $_POST['door']);
        $door_x = $door_pos[0];
        $door_y = $door_pos[1];

        $sql = "INSERT INTO buildings
                VALUES ('', '$_POST[name]', '$_SESSION[ed_sector]', '$_SESSION[ed_x]', '$_SESSION[ed_y]', '$_POST[image]', '$_POST[sector]', '$door_x', '$door_y')";

        $result = $db->db_query($sql);

        update_cache();

        makePage('building_added');
}
?>