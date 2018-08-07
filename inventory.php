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

if(isset($_GET['genimg']))
{
        // make sure its not another protocol, should be just a path
        if(strstr($_GET['genimg'], '://'))
        {
                die('hacking attempt');
        }

        $im = imagecreatefromgif($_GET['genimg']);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagechar($im, 1, 2, 2, $_GET['num'], $black);

        header('Content-type: image/png');
        imagepng($im);

        exit;
}

if(!isset($_GET['action']))
{
        $eq = 0;
        // list items...
        $sql = "SELECT * FROM inventory
                        WHERE pid = '$user[0]'";

        $result = $db->db_query($sql);

        $output = 'Use this page to equip items you have bought from NPCs. To equip an item simply click it. Items you have equiped will have a border and will also be useable in battles.<br /><br /><b><center>Weapons</center></b><br />';
        $output2 = '<br /><br /><b><center>Items</center></b><br />';
        while($row = $db->db_fetch_array($result))
        {

                if($row['type'] == 'weapon')
                {
                        $sql = "SELECT * FROM weapons
                                        WHERE id = '$row[2]'";

                        $result2 = $db->db_query($sql);
                        $item = $db->db_fetch_array($result2);

                        // give the item a red border if its equipped
                        $border = 'border="0"';
                        if($user[18] == $item[0] && $eq == 0)
                        {
                                $border = 'border="1" bordercolor="#111111"';
                                $eq = 1;
                        }
                        $alt = $item[1];
                        $img = 'inventory.php?genimg=images/weapons/'.$item[4].'.gif&num='.$row[3];

                        $output .= '<a href="inventory.php?action=equip&eq='.$item[0].'"><img src="'.$img.'" '.$border.' alt="'.$alt.'"></a>';
                }
                elseif($row['type'] == 'item')
                {
                        $sql = "SELECT * FROM items
                                        WHERE id = '$row[2]'";

                        $result2 = $db->db_query($sql);
                        $item = $db->db_fetch_array($result2);

                        $alt = $item['name'] . '      ' . $item['effect_desc'];
                        $img = 'inventory.php?genimg=images/items/' . $item['image'] . '.gif&num='.$row[3];

                        $output2 .= '<a href="inventory.php?action=useitem&eq='.$item[0].'"><img border="0" src="'.$img.'" alt="'.$alt.'"></a>';
                }
        }

        $page = new Template();

        $page->simplePage($output . $output2);
}
elseif($_GET['action'] == 'equip')
{
        // make sure the user has this item
        $sql = "SELECT * FROM inventory
                WHERE pid = '$user[0]'
                AND item_id = '$_GET[eq]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);

        if($num == 0)
        {
                $page = new Template();
                $page->simplePage('You do not have this item.', 1);
        }
        else
        {
                $sql = "UPDATE players
                                SET equip1 = '$_GET[eq]'
                                WHERE id = '$user[0]'";

                $result = $db->db_query($sql);
                header("Location: inventory.php");
                exit;
        }
}
elseif($_GET['action'] == 'useitem')
{
        // make sure that the player has it
        $sql = "SELECT * FROM inventory
                        WHERE item_id = '$_GET[eq]' AND pid = '$user[id]'";

        $result = $db->db_query($sql);
        $num = $db->db_num_rows($result);
        $user_item = $db->db_fetch_array($result);

        if($num == 0)
        {
                $page = new Template();

                $page->simplePage('You do not have this item.', 1);
        }
        else
        {
                // get an array of the item's stats
                $sql = "SELECT * FROM items
                                WHERE id = '$_GET[eq]'";

                $result = $db->db_query($sql);
                $item = $db->db_fetch_array($result);

                $effect = $item['effect'];

                // determine if the function is plus or minus
                //if(strstr($item['effect'], '+'))
                if($effect{0} == '+')
                {
                        // add to the effect type
                        $add = substr($item['effect'], 1);
                        $new = $user[$item['effect_type']] + $add;

                        // is there a cap?
                        if($item['effect_cap'] != '')
                        {
                                // is it a variable or a static number?
                                if($item['effect_cap']{0} == '$')
                                {
                                        $var = substr($item['effect_cap'], 1);
                                        $cap = $user[$var];
                                }
                                else
                                {
                                        $cap = $item['effect_cap'];
                                }

                                // make sure it's not larger then the cap
                                if($new > $cap)
                                {
                                        $new = $cap;
                                }
                        }

                        // now add
                        $sql = "UPDATE players
                                        SET $item[effect_type] = '$new'
                                        WHERE id = '$user[id]'";

                        $result = $db->db_query($sql);
                }
                else
                {
                        // subtract from the effect type
                        $sub = substr($item['effect'], 1);
                        $new = $user[$item['effect_type']] - $sub;

                        if($new < 0)
                        {
                                $new = 0;
                        }

                        // now subtract
                        $sql = "UPDATE player
                                        SET $item[effect_type] = '$new'
                                        WHERE id = '$user[id]'";

                        $result = $db->db_query($sql);
                }

                // remove it from the inventory
                if($user_item['quantity'] > 1)
                {
                        $new_quant = $user_item['quantity'] - 1;

                        $sql = "UPDATE inventory
                                        SET quantity = '$new_quant'
                                        WHERE item_id = '$_GET[eq]' AND pid = '$user[id]'";
                        $result = $db->db_query($sql);
                }
                else
                {
                        $sql = "DELETE FROM inventory
                                        WHERE item_id = '$_GET[eq]' AND pid = '$user[id]'";

                        $result = $db->db_query($sql);
                }

                $page = new Template();
                $page->simplePage('Item used.<br><br><a href="inventory.php">Back</a>');
        }
}
//---------------------------------------------
?>
