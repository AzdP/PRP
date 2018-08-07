<html>
<head>
<title>Dialogue</title>
<meta http-equiv="Content-Type" content="text/html;">
</head>

<frameset cols="170,*" rows="*" border="2" framespacing="0" frameborder="yes">
  <frame src="dialogue.php?npc=<?=$_GET['npc']?>&left=1" name="topics" marginwidth="3" marginheight="3" scrolling="auto">
  <frame src="dialogue.php?npc=<?=$_GET['npc']?>" name="text" marginwidth="10" marginheight="10" scrolling="auto">
</frameset>

<noframes>
	<body bgcolor="#FFFFFF" text="#000000">
		<p>Sorry, your browser doesn't seem to support frames</p>
	</body>
</noframes>
</html>