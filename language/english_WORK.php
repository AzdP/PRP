<?php
//////////////////////////////////////////////////////
//
//                The PHP RPG Project
//
//        Version                        :        1.0.0a
//        Author                        :        The XPHPX Team!
//
//
//////////////////////////////////////////////////////

//////////////////////////////////////////////////////
//
// Language             :         English
// Pack Version         :         1.0 development
//
//////////////////////////////////////////////////////

$lang['system_msg'] = 'System Messages';
$lang['name'] = 'Name';
$lang['level'] = 'Level';
$lang['class'] = 'Class';
$lang['experience'] = 'Exp';
$lang['gold'] = 'Gold';
$lang['player_stats'] = 'Player Statistics';
$lang['actions'] = 'Actions';
$lang['movement'] = 'Movement';
$lang['user_list'] = 'Player List';
$lang['username'] = 'Username';
$lang['password'] = 'Password';
$lang['email'] = 'Email';
$lang['class'] = 'Class';
$lang['avatar'] = 'Avatar';
$lang['rememberme'] = 'Remember Me';
$lang['click_register'] = 'Click here to register';
$lang['login'] = 'Log In';
$lang['register'] = 'Register';
$lang['submit_msg'] = 'Submit Message';
$lang['move'] = 'Move';
$lang['online'] = 'Users Online';
$lang['none_online'] = 'No other users online!';
$lang['user_info'] = 'User Information';
$lang['userlevel'] = 'Level';
$lang['rank'] = 'Rank';
$lang['class'] = 'Class';
$lang['back_to_list'] = 'Back to the list';
$lang['back_to_game'] = 'Back to the game';
$lang['avatar'] = 'Avatar';
$lang['memberlist'] = 'Member List';
$lang['back'] = 'Back';
$lang['next'] = 'Next';
$lang['perpg'] = 'Per Page';
$lang['asc_order'] = 'Ascending';
$lang['desc_order'] = 'Descending';
$lang['exp'] = 'Experience';
$lang['buy_instruct'] = 'To buy an item simply click it and it will be automatically purchased.';
$lang['weapons'] = 'Weapons';
$lang['chat'] = 'Chat';
$lang['pvp_won'] = "You've won the battle!";

// Player VS. Player
$lang['no_such_user'] = 'No such user in the database.';
$lang['user_not_online'] = 'The user you specified is not online!';
$lang['pvp_waiting'] = 'Waiting for user to accept your challenge. This page will refresh every 5 seconds.';
$lang['pvp_cancelled'] = 'You have cancelled the battle!';
$lang['pvp_cancel'] = 'Cancel Battle Request';

// Links
$lang['play_music'] = 'Play Music';
$lang['options'] = 'Options';
$lang['inventory'] = 'Inventory';
$lang['menu'] = 'Menu';
$lang['help'] = 'Help!';
$lang['logout'] = 'Logout';
$lang['home'] = 'Home';

// Special

// $image is an array with two keys
// the key 'image' contains the path to the gd image.
// the key 'db' contains a hash which will be used
// to access a couple of things.
// first off, it'll give access to the user ip,
// meaning the IP addy used to request the image, so it can match
// with the IP of the user who hit 'submit'. second, it'll give access
// to the hash id of the image. if both those don't match up -
// access denied. finally, itll give access to what the actual
// number was inside the image. if those three don't match up -
// access denied. if all three of them do match up, access granted.

$image = randImage();

$lang['randtext'] = 'Enter the numbers you see in the image';
$lang['randimg'] = $image['image'];
$lang['asdf'] = $image['db'];

function randImage()
{
        $temp['image'] = 'images/retard.gif';
        $temp['db'] = '420';
        return $temp;
        // gonna rip from some random image generating script probably
}


?>