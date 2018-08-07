<html>
<head>
<style>
<!--
body,td           { font-family: Verdana; font-size: 10px }
-->
</style>
<title>Chat</title>
</head>
<body leftmargin=0 topmargin=0>
<center>
<form action="chat.php" method="post" name="form1">
<input type="text" name="message" value="" style="font-family: Verdana; font-size: 10;" maxlength="255" size="26">
<input type="submit" value="     {L_submit_msg}     " style="font-family: Verdana; font-size: 8px">
</form>
{messages}
</center>
</body>
</html>