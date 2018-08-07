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
include("includes/startup.php");

if(!isset($_POST['submit']))
{
        // get a list of charactors
        $charactors = '';
        $char_images = './images/pc';

        $dp = opendir($char_images);
        while($file = readdir($dp))
        {
                if(!is_dir($file))
                {
                        $val = str_replace(".gif", "", $file);
                        $char_array[$val] = "<option value=$val>$file</option>";
                }
        }

        ksort($char_array);

        foreach($char_array as $value)
        {
                $charactors .= $value;
        }

        $page = new Template();

        $page->set_files(array(
        'header' => 'simple_header.tpl',
        'body' => 'register_body.tpl',
        'footer' => 'simple_footer.tpl'));

        $page->assign_vars(array(
        'char_list' => $charactors));

        $page->ppage();
}
else
{
                // clean the post variables
                clean_inputs();

                // make sure all the variables are set
                if(!$_POST['username'] || !$_POST['password'] || !$_POST['email'])
                {
                        $page = new Template();
                        $page->simplePage('<center>' . $lang['register_fillout'] . '<br /><a href="register.php">' . $lang['back'] . '</a></center>', 1);
                }

        // make sure the username isnt already taken
        $sql = "SELECT id FROM players
                WHERE name = '$_POST[username]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num > 0)
        {
                        $page = new Template();
            $page->simplePage('<center>'. $lang['register_taken'] . '<br /><a href="register.php">' . $lang['back'] . '</a></center>', 1);
        }

        // register the user
        $date = time();
        $sql = "INSERT INTO players (id,name,email,password,join_date,ip_address,char_img,sector,x,y,level,class,exp,hp,maxhp,mp,maxmp,gold,equip1,userlvl,music,clan,accept_tax)
                VALUES ('','$_POST[username]','$_POST[email]','$_POST[password]','$date','$_SERVER[REMOTE_ADDR]','$_POST[char]','$config[default_sector]','100','150','1','$_POST[class]','0','10','10','10','10','500','', '1','0','0','0')";

        $result = $db->db_query($sql);

                $page = new Template();
        // yes we did it
        $page->simplePage('<center>'.$lang['register_success'] . ' <a href="login.php">'.$lang['here'].'</a></center>');
}
?>
