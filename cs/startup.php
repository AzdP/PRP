<?php
session_start();

// make sure sessions are set
if(!session_is_registered('ed_x'))
{
        // reset x and y
        session_register('ed_x');
        session_register('ed_y');
        session_register('sector');
        session_register('selected');
        session_register('selObject');

        $_SESSION['ed_x'] = 0;
        $_SESSION['ed_y'] = 0;
        $_SESSION['ed_sector'] = 1;
        $_SESSION['selected'] = 0;
        $_SESSION['selObject'] = false;
}

// main files
require("../settings.php");
require('../includes/db.inc.php');

// construction set files
require('includes/editor.php');
require('includes/construction.inc.php');
require('includes/html.inc.php');
require('includes/functions.inc.php');

// Connect to the SQL DB
$db = new db($db['host'], $db['user'], $db['pass'], $db['name']);

if(!$db->db_connection)
{
        die("Connection Error");
}

// Grab settings
$sql = 'SELECT * FROM config';

$result = $db->db_query($sql);

while($row = $db->db_fetch_array($result))
{
        $config[$row['config_name']] = $row['config_value'];
}

// sector info
$sql = "SELECT * FROM sectors
                WHERE id = '$_SESSION[ed_sector]'";

$result = $db->db_query($sql);
$sector = $db->db_fetch_array($result);

// create the session id
$sessid = md5($prefs['passwd']);

// setup the editor functions
$editor = new Editor();

$alerts = clear_alerts();
?>
