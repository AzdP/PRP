<?php
//
// This is for making a basic page with a language
// variable.
//
function makePage($var, $addonmsg = '', $echoit = 1)
{
        global $html, $src_file;

        if(!isset($html[$var]))
    {
            die('<b>No such HTML variable "'.$var.'".</b>');
    }

        $html[$var] = str_replace('{self}', $src_file, $html[$var]);

        if($echoit == 1)
        {
                echo $html['header'];
            echo $addonmsg;
            echo $html[$var];
            echo $html['footer'];
        }
        else
        {
            $output = $html['header'];
            $output .= $addonmsg;
            $output .= $html[$var];
            $output .= $html['footer'];

                return $output;
        }
}

//
// This function will allow you to add a system alert
//
function add_alert($alert)
{
        global $alert_text;

                if($alert_text == 'n/a')
                {
                        $alert_text = '';
                }

                if($alert_text != '')
                {
                        $alert_text .= '<br />';
                }

        $alert_text .= $alert;

                return $alert_text;
}

//
// This function clears all the alerts
//
function clear_alerts()
{
        global $alert_text;

        $alert_text = 'n/a';

                return $alert_text;
}

//
// This function makes sure the specified post variables are set
//
function check_post($post_array)
{
        foreach($post_array as $value)
        {
                if(!$value)
                {
                        // its not set, therefor the function should return false
                        return false;
                }
        }
        // all the vars are set
        return true;
}

//
// This function cleans all post and get variables
//
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

//
// This will update the objects cache for the game
//
function update_cache()
{
        global $db, $config;

        // get the real offset values for the template that is in use
        require('../templates/'.$config['template'].'/tpl_config.php');

        if(!is_writeable('../cache'))
        {
                die('Please chmod /cache/ 777!');
        }

        // get a list of sectors
        $sql = "SELECT * FROM sectors";

        $result = $db->db_query($sql);
        while($row = $db->db_fetch_array($result))
        {
                $sector[$row[0]] = $row[2];
        }

        // build each sector
        foreach($sector as $key => $value)
        {
                $div_html = '';

                // terrain
                $sql = "SELECT * FROM terrain
                        WHERE sector_id = '$key'";

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

                        $div_html .= "<div style=\"LEFT: ".($row[5] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[6] + $yoffset)."px; $layer\"><img src=images/obj/$row[3]$ext alt=\"$row[2]\"></div>\n";
                }

                // buildings
                $sql = "SELECT * FROM buildings
                        WHERE sector_id = '$key'";

                $result = $db->db_query($sql);
                while($row = $db->db_fetch_array($result))
                {
                        $ext = '';
                        if(!strstr($row['image'], '.'))
                        {
                                $ext = '.gif';
                        }

                        $div_html .= "<div style=\"LEFT: ".($row[3] + $xoffset)."px; VISIBILITY: visible; POSITION: absolute; TOP: ".($row[4] + $yoffset)."px; Z-index: 2;\"><img src=images/buildings/$row[image]$ext alt=\"$row[name]\"></div>\n";
                }

                // write to a file
                $fp = fopen('../cache/' . $key . 'html.txt', 'w');
                fwrite($fp, $div_html);
        }

        return true;
}
?>
