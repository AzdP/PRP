<?php
require('includes/startup.php');

$chat = new Chat;

if(isset($_POST['message']))
{
	// a chat msg has been submitted, if its empty then do nothing of course
	if($_POST['message'] != '')
	{
		$chat->addChat($_POST['message']);
	}
}

$messages = $chat->getChat();

$page = new Template();

$page->set_files(array(
'header' => '',
'main' => 'chat_frame.tpl',
'footer' => ''));

$page->assign_vars(array(
'messages' => $messages));

$page->ppage();
?>
