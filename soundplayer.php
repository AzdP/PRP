<html>
<head>
<title>Music Player</title>
</head>
<?php
echo '<bgsound src="music/'.$_GET['music'].'" loop="-1">';
?>
<body>
<font size=2>
Close this window to stop music.
<Br><br>
TIP: Don't just minimize this window or the music will stop playing. Instead just click on the game window to bring it into focus.</font>
</body>
</html>