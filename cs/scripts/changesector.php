<?php
if(!isset($_POST['submit']) && !isset($_GET['sector']))
{
        // grab a list of sectors
        $sql = "SELECT * FROM sectors";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                $list .= "<option value=$row[id]>$row[name]</option>";
        }

        // build the page to display a list and a submit button
        $page = makepage('change_sector', '', 0);
        $page = str_replace('{list}', $list, $page);

        echo $page;
}
else
{
        $new_sector = $_POST['sector'];
        if(isset($_GET['sector']))
        {
                $new_sector = $_GET['sector'];
        }

        $_SESSION['ed_sector'] = $new_sector;

        // close the window if it's requested
        if(isset($_GET['close']))
        {
                makepage('changed_sector', '<script>window.close();</script>');
                exit;
        }

        makepage('changed_sector');
}
?>
